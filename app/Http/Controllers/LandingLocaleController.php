<?php

namespace App\Http\Controllers;

use App\Support\AppUrl;
use App\Support\LandingLocalePreference;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LandingLocaleController extends Controller
{
    public function __invoke(Request $request, string $locale): RedirectResponse
    {
        $locale = AppUrl::isUiLocale($locale) ? $locale : 'pl';

        $next = LandingLocalePreference::safeNextPath($request->query('next'), $locale);
        $cookie = cookie(
            LandingLocalePreference::cookieName(),
            $locale,
            LandingLocalePreference::COOKIE_MINUTES,
            '/',
            null,
            $request->secure(),
            true,
            false,
            'Lax'
        );

        if ($next !== null) {
            return redirect()->to($next)->withCookie($cookie);
        }

        $landingRoute = match ($locale) {
            'en' => 'en.landing',
            'es' => 'es.landing',
            'fr' => 'fr.landing',
            'de' => 'de.landing',
            default => 'pl.landing',
        };

        return redirect()->route($landingRoute)->withCookie($cookie);
    }
}
