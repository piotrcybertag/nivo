<?php

namespace App\Support;

use Illuminate\Http\Request;

class CookieConsent
{
    public static function consentCookieName(): string
    {
        return (string) config('nivo_landing.cookie_consent_name');
    }

    public static function accepted(Request $request): bool
    {
        $v = (string) $request->cookie(self::consentCookieName());

        return str_starts_with($v, 'accepted');
    }

    public static function hasConsentCookie(Request $request): bool
    {
        return $request->cookie(self::consentCookieName()) !== null;
    }

    public static function shouldShowBanner(Request $request): bool
    {
        return ! self::hasConsentCookie($request);
    }
}
