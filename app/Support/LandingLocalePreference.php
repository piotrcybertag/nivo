<?php

namespace App\Support;

use Illuminate\Http\Request;

final class LandingLocalePreference
{
    public const COOKIE_NAME = 'nivo_landing_locale';

    public const COOKIE_MINUTES = 525600; // 365 dni

    public static function cookieName(): string
    {
        return self::COOKIE_NAME;
    }

    /** @return 'pl'|'en'|null */
    public static function cookieValue(Request $request): ?string
    {
        $v = $request->cookie(self::COOKIE_NAME);
        if ($v === 'pl' || $v === 'en') {
            return $v;
        }

        return null;
    }

    public static function acceptLanguageWantsPolish(Request $request): bool
    {
        $header = $request->header('Accept-Language');
        if ($header === null || trim($header) === '') {
            return false;
        }

        return $request->getPreferredLanguage(['pl', 'en']) === 'pl';
    }

    /**
     * Bezpieczna ścieżka względna do przekierowania po wyborze języka (bez open redirect).
     */
    public static function safeNextPath(?string $next, string $locale): ?string
    {
        if (! is_string($next) || $next === '') {
            return null;
        }

        if (strlen($next) > 2048 || preg_match('/[\x00-\x1f\x7f]/', $next)) {
            return null;
        }

        if (! str_starts_with($next, '/') || str_starts_with($next, '//')) {
            return null;
        }

        if (str_contains($next, '://') || str_contains($next, '\\')) {
            return null;
        }

        if (! preg_match('{^/[A-Za-z0-9._\~!$&\'()*+,;=:@%\-/?#\[\]]*$}', $next)) {
            return null;
        }

        return $next;
    }
}
