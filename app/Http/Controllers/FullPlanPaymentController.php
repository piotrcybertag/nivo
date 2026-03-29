<?php

namespace App\Http\Controllers;

use App\Models\Uzytkownik;
use App\Services\PracownicyTableService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class FullPlanPaymentController extends Controller
{
    /**
     * Przekierowanie do Stripe Payment Link z client_reference_id = id konta (powrót weryfikujemy przez API).
     */
    public function start(Request $request): RedirectResponse
    {
        if (! session('uzytkownik_id') || session('login_via_link') || session('uzytkownik_plan') !== 'FREE') {
            return redirect()->route('upgrade')
                ->with('error', 'Strona płatności jest dostępna tylko dla użytkowników planu Free zalogowanych hasłem.');
        }

        $uzytkownik = Uzytkownik::find(session('uzytkownik_id'));
        if (! $uzytkownik || $uzytkownik->plan !== 'FREE') {
            return redirect()->route('home');
        }

        $base = rtrim((string) config('services.stripe.payment_link'), '?&');
        $glue = str_contains($base, '?') ? '&' : '?';
        $url = $base.$glue.'client_reference_id='.rawurlencode((string) $uzytkownik->id);
        if ($uzytkownik->email) {
            $url .= '&prefilled_email='.rawurlencode((string) $uzytkownik->email);
        }

        return redirect()->away($url);
    }

    /**
     * Strona po płatności — URL w Stripe: .../platnosc/full/dziekujemy?session_id={CHECKOUT_SESSION_ID}
     */
    public function thankYou(Request $request): View
    {
        $secret = config('services.stripe.secret');
        if (! is_string($secret) || $secret === '') {
            return view('platnosc-full-dziekujemy', ['status' => 'brak_klucza']);
        }

        $sessionId = $request->query('session_id');
        if (! is_string($sessionId) || ! preg_match('/^cs_[a-zA-Z0-9]+$/', $sessionId)) {
            return view('platnosc-full-dziekujemy', ['status' => 'brak_sesji_stripe']);
        }

        $response = Http::withBasicAuth($secret, '')
            ->acceptJson()
            ->timeout(15)
            ->get('https://api.stripe.com/v1/checkout/sessions/'.rawurlencode($sessionId));

        if (! $response->successful()) {
            return view('platnosc-full-dziekujemy', ['status' => 'blad_stripe']);
        }

        $data = $response->json();
        $paymentStatus = (string) ($data['payment_status'] ?? '');
        $checkoutStatus = (string) ($data['status'] ?? '');
        $oplacone = in_array($paymentStatus, ['paid', 'no_payment_required'], true)
            || $checkoutStatus === 'complete';
        if (! $oplacone) {
            return view('platnosc-full-dziekujemy', ['status' => 'nieoplacone']);
        }

        $clientRef = $data['client_reference_id'] ?? null;
        if (! is_string($clientRef) && ! is_numeric($clientRef)) {
            return view('platnosc-full-dziekujemy', ['status' => 'brak_powiazania']);
        }

        $userId = (int) $clientRef;
        if ($userId < 1) {
            return view('platnosc-full-dziekujemy', ['status' => 'brak_uzytkownika']);
        }

        $uzytkownik = Uzytkownik::find($userId);
        if (! $uzytkownik) {
            return view('platnosc-full-dziekujemy', ['status' => 'brak_uzytkownika']);
        }

        if ($uzytkownik->plan !== 'FULL') {
            $uzytkownik->update(['plan' => 'FULL']);
            $uzytkownik->refresh();
        }

        session([
            'uzytkownik_id' => $uzytkownik->id,
            'uzytkownik_typ' => $uzytkownik->typ,
            'uzytkownik_plan' => 'FULL',
            'uzytkownik_imie_nazwisko' => $uzytkownik->imie_nazwisko,
            'login_via_link' => false,
        ]);

        if ($uzytkownik->typ !== 'ADM') {
            app(PracownicyTableService::class)->ensureTableForCurrentUser();
        }

        return view('platnosc-full-dziekujemy', [
            'status' => 'sukces',
            'uzytkownik' => $uzytkownik,
        ]);
    }
}
