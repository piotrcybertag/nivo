<?php

namespace App\Http\Controllers;

use App\Support\LandingLocalePreference;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LandingLocaleController extends Controller
{
    public function __invoke(Request $request, string $locale): RedirectResponse
    {
        $locale = $locale === 'en' ? 'en' : 'pl';

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

        return redirect()->route($locale === 'en' ? 'en.landing' : 'home')->withCookie($cookie);
    }
}
