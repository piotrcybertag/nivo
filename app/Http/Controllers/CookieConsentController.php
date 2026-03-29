<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CookieConsentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'decision' => ['required', 'in:accept,reject'],
        ]);

        $name = config('nivo_landing.cookie_consent_name');
        if ($validated['decision'] === 'accept') {
            $value = 'accepted';
            $minutes = (int) config('nivo_landing.cookie_consent_minutes');
        } else {
            $value = 'rejected';
            $minutes = (int) config('nivo_landing.cookie_reject_minutes');
        }

        // httpOnly=false — baner synchronizuje widoczność z document.cookie (jak w Aveo).
        return back()->withCookie(cookie((string) $name, $value, $minutes, '/', null, null, false));
    }
}
