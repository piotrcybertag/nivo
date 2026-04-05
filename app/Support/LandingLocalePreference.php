<?php

namespace App\Support;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Cookie;

final class LandingLocalePreference
{
    public const COOKIE_NAME = 'nivo_landing_locale';

    public const COOKIE_MINUTES = 525600; // 365 dni

    /**
     * Kolejność wpływa tylko na remisy w dopasowaniu; zwykle wygrywa jakość z nagłówka Accept-Language.
     *
     * @return list<string>
     */
    public static function supportedLanguageCodes(): array
    {
        return ['pl', 'de', 'fr', 'es', 'en'];
    }

    public static function cookieName(): string
    {
        return self::COOKIE_NAME;
    }

    /** @return 'pl'|'en'|'es'|'fr'|'de'|null */
    public static function cookieValue(Request $request): ?string
    {
        $v = $request->cookie(self::COOKIE_NAME);
        if (is_string($v) && AppUrl::isUiLocale($v)) {
            return $v;
        }

        return null;
    }

    /**
     * Najlepsze dopasowanie języka UI spośród {@see supportedLanguageCodes()} wg nagłówka Accept-Language.
     */
    public static function preferredLocaleFromAcceptLanguage(Request $request): ?string
    {
        $header = $request->header('Accept-Language');
        if ($header === null || trim($header) === '') {
            return null;
        }

        $code = $request->getPreferredLanguage(self::supportedLanguageCodes());

        return (is_string($code) && AppUrl::isUiLocale($code)) ? $code : null;
    }

    public static function landingRouteNameForLocale(string $locale): string
    {
        return match ($locale) {
            'en' => 'en.landing',
            'es' => 'es.landing',
            'fr' => 'fr.landing',
            'de' => 'de.landing',
            default => 'pl.landing',
        };
    }

    /**
     * Język UI dla stron bez prefiksu (np. /login): referer z naszego hosta, cookie, potem Accept-Language.
     *
     * @return 'pl'|'en'|'es'|'fr'|'de'
     */
    public static function resolveLocaleForRequest(Request $request): string
    {
        $referer = $request->headers->get('Referer');
        if (is_string($referer) && $referer !== '') {
            $refHost = parse_url($referer, PHP_URL_HOST);
            $appHost = parse_url((string) config('app.url'), PHP_URL_HOST);
            if (is_string($refHost) && $refHost !== '' && is_string($appHost) && $appHost !== '' && strcasecmp($refHost, $appHost) === 0) {
                $path = trim((string) (parse_url($referer, PHP_URL_PATH) ?? ''), '/');
                if ($path !== '') {
                    $first = explode('/', $path, 2)[0];
                    if (AppUrl::isUiLocale($first)) {
                        return $first;
                    }
                }
            }
        }

        $cookie = self::cookieValue($request);
        if ($cookie !== null) {
            return $cookie;
        }

        $fromBrowser = self::preferredLocaleFromAcceptLanguage($request);
        if ($fromBrowser !== null) {
            return $fromBrowser;
        }

        return 'en';
    }

    /** Ciasteczko preferencji języka (jak po przełączniku na landingu). */
    public static function preferenceCookie(Request $request, string $locale): Cookie
    {
        $locale = AppUrl::isUiLocale($locale) ? $locale : 'pl';

        return cookie(
            self::cookieName(),
            $locale,
            self::COOKIE_MINUTES,
            '/',
            null,
            $request->secure(),
            true,
            false,
            'Lax'
        );
    }

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
