<?php

namespace App\Support;

use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Http\Request;

/**
 * URL-e aplikacji z prefiksem /pl/, /en/, /es/, /fr/ lub /de/ wg bieżącego URL albo sesji.
 */
final class AppUrl
{
    public const SESSION_UI_LOCALE = 'ui_locale';

    public static function isUiLocale(string $s): bool
    {
        return $s === 'pl' || $s === 'en' || $s === 'es' || $s === 'fr' || $s === 'de';
    }

    public static function segmentFromRequest(): ?string
    {
        $s = request()->segment(1);

        return self::isUiLocale((string) $s) ? $s : null;
    }

    /** @return 'pl'|'en'|'es'|'fr'|'de' */
    public static function uiLocale(): string
    {
        $s = self::segmentFromRequest();
        if ($s !== null) {
            return $s;
        }

        $v = session(self::SESSION_UI_LOCALE);
        if (self::isUiLocale((string) $v)) {
            return $v;
        }

        $lf = session('login_form_locale');
        if (self::isUiLocale((string) $lf)) {
            return $lf;
        }

        $c = LandingLocalePreference::cookieValue(request());
        if ($c !== null && self::isUiLocale($c)) {
            return $c;
        }

        return 'pl';
    }

    /**
     * Jak route(), ale z nazwą z prefiksem bieżącego języka (pl.* / en.* / es.* / fr.* / de.*).
     *
     * @param  array|string|int|float|UrlRoutable|null  $parameters
     */
    public static function route(string $name, mixed $parameters = [], bool $absolute = true): string
    {
        return route(self::uiLocale().'.'.$name, $parameters, $absolute);
    }

    /** @return 'pl'|'en'|'es'|'fr'|'de' */
    public static function uiLocaleFromRequest(Request $request): string
    {
        $s = $request->segment(1);
        if (self::isUiLocale((string) $s)) {
            return $s;
        }

        return LandingLocalePreference::resolveLocaleForRequest($request);
    }
}
