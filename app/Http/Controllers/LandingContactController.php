<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class LandingContactController extends Controller
{
    public function store(Request $request)
    {
        if ($request->routeIs('en.landing.contact')) {
            App::setLocale('en');
        } else {
            App::setLocale('pl');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
            'rodo' => ['accepted'],
        ], [
            'name.required' => __('landing.contact.validation.name_required'),
            'email.required' => __('landing.contact.validation.email_required'),
            'email.email' => __('landing.contact.validation.email_email'),
            'message.required' => __('landing.contact.validation.message_required'),
            'message.max' => __('landing.contact.validation.message_max'),
            'rodo.accepted' => __('landing.contact.validation.rodo_accepted'),
        ]);

        $h = static fn (string $s): string => htmlspecialchars($s, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $nameSafe = $h($validated['name']);
        $emailSafe = $h($validated['email']);
        $messageSafe = nl2br($h($validated['message']));

        $htmlAdmin = '<p><strong>'.e(__('landing.email_admin.lead')).'</strong></p>'
            .'<p><strong>'.e(__('landing.email_admin.name_label')).'</strong> '.$nameSafe.'<br>'
            .'<strong>'.e(__('landing.email_admin.email_label')).'</strong> '.$emailSafe.'</p>'
            .'<p><strong>'.e(__('landing.email_admin.body_label')).'</strong></p><p>'.$messageSafe.'</p>';

        $footerHost = parse_url((string) config('app.url'), PHP_URL_HOST) ?: 'nivo.cyberrum.eu';
        $htmlUser = view('emails.landing-kontakt-potwierdzenie', [
            'logoUrl' => url('storage/nivo.png'),
            'name' => $validated['name'],
            'message' => $validated['message'],
            'footerHost' => $footerHost,
        ])->render();

        $adminTo = config('nivo_landing.contact_admin_email');

        try {
            Mail::html($htmlAdmin, function ($message) use ($adminTo, $validated): void {
                $message->to((string) $adminTo)
                    ->replyTo($validated['email'], $validated['name'])
                    ->subject(__('landing.email_admin.subject'));
            });

            Mail::html($htmlUser, function ($message) use ($validated): void {
                $message->to($validated['email'])
                    ->subject(__('landing.email_confirm.subject'));
            });
        } catch (\Throwable $e) {
            Log::error('landing.kontakt', ['message' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('landing_contact_error', __('landing.contact.error_send'));
        }

        return back()->with('landing_contact_success', true);
    }
}
