<?php

namespace App\Http\Controllers;

use App\Models\Uzytkownik;
use App\Services\PracownicyTableService;
use App\Support\AdminLog;
use App\Support\AppUrl;
use App\Support\LandingLocalePreference;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /** @return 'pl'|'en'|'es' */
    private function resolveLoginLocale(Request $request): string
    {
        $s = $request->segment(1);
        if (AppUrl::isUiLocale((string) $s)) {
            return $s;
        }

        return LandingLocalePreference::resolveLocaleForRequest($request);
    }

    public function showLoginForm(Request $request)
    {
        if (session('uzytkownik_id')) {
            session()->forget(['uzytkownik_id', 'uzytkownik_typ', 'uzytkownik_plan', 'uzytkownik_imie_nazwisko', 'login_via_link']);
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        $locale = $this->resolveLoginLocale($request);
        session(['login_form_locale' => $locale]);
        App::setLocale($locale);

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $locale = $this->resolveLoginLocale($request);
        session(['login_form_locale' => $locale]);
        App::setLocale($locale);

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $uzytkownik = Uzytkownik::where('email', $request->email)->first();

        if (! $uzytkownik || ! Hash::check($request->password, $uzytkownik->password)) {
            throw ValidationException::withMessages([
                'email' => [__('auth.failed')],
            ]);
        }

        session([
            'uzytkownik_id' => $uzytkownik->id,
            'uzytkownik_typ' => $uzytkownik->typ,
            'uzytkownik_plan' => $uzytkownik->plan,
            'uzytkownik_imie_nazwisko' => $uzytkownik->imie_nazwisko,
            'login_via_link' => false,
            AppUrl::SESSION_UI_LOCALE => $locale,
        ]);

        if ($uzytkownik->typ !== 'ADM') {
            app(PracownicyTableService::class)->ensureTableForCurrentUser();
        }

        AdminLog::userLogin((string) $uzytkownik->imie_nazwisko);

        return redirect()->intended(route($locale.'.schemat'))
            ->with('success', __('auth.login_success'))
            ->with('analytics_event', ['name' => 'login', 'params' => []])
            ->withCookie(LandingLocalePreference::preferenceCookie($request, $locale));
    }

    public function logout(Request $request)
    {
        $locale = $this->resolveLoginLocale($request);
        App::setLocale($locale);

        session()->forget(['uzytkownik_id', 'uzytkownik_typ', 'uzytkownik_plan', 'uzytkownik_imie_nazwisko', 'login_via_link']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route($locale.'.landing')->with('success', __('auth.logout_success'));
    }

    public function loginViaLink(string $token): RedirectResponse
    {
        $request = request();
        $locale = LandingLocalePreference::resolveLocaleForRequest($request);
        App::setLocale($locale);

        $uzytkownik = Uzytkownik::where('login_link_token', $token)->first();
        if (! $uzytkownik) {
            return redirect()->route(AppUrl::uiLocaleFromRequest($request).'.login')->with('error', __('auth.link_invalid'));
        }

        session([
            'uzytkownik_id' => $uzytkownik->id,
            'uzytkownik_typ' => $uzytkownik->typ,
            'uzytkownik_plan' => $uzytkownik->plan,
            'uzytkownik_imie_nazwisko' => $uzytkownik->imie_nazwisko,
            'login_via_link' => true,
            AppUrl::SESSION_UI_LOCALE => $locale,
        ]);

        if ($uzytkownik->typ !== 'ADM') {
            app(PracownicyTableService::class)->ensureTableForCurrentUser();
        }

        AdminLog::userLogin((string) $uzytkownik->imie_nazwisko);

        return redirect()->route($locale.'.schemat')
            ->with('success', __('auth.login_via_link_success'))
            ->withCookie(LandingLocalePreference::preferenceCookie($request, $locale));
    }
}
