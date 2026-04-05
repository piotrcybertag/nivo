<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class LandingAlternateUrls
{
    /** @var array<string, string> */
    private const PL_TO_EN = [
        'kartoteka' => 'directory',
        'schemat' => 'org-chart',
        'przeglad' => 'overview',
    ];

    /** @var array<string, string> */
    private const PL_TO_ES = [
        'kartoteka' => 'directorio',
        'schemat' => 'organigrama',
        'przeglad' => 'vista-general',
    ];

    /** @var array<string, string> */
    private const PL_TO_FR = [
        'kartoteka' => 'annuaire',
        'schemat' => 'organigramme',
        'przeglad' => 'vue-ensemble',
    ];

    /** @var array<string, string> */
    private const EN_TO_PL = [
        'directory' => 'kartoteka',
        'org-chart' => 'schemat',
        'overview' => 'przeglad',
    ];

    /** @var array<string, string> */
    private const ES_TO_PL = [
        'directorio' => 'kartoteka',
        'organigrama' => 'schemat',
        'vista-general' => 'przeglad',
    ];

    /** @var array<string, string> */
    private const FR_TO_PL = [
        'annuaire' => 'kartoteka',
        'organigramme' => 'schemat',
        'vue-ensemble' => 'przeglad',
    ];

    /** @var array<string, string> */
    private const PL_TO_DE = [
        'kartoteka' => 'verzeichnis',
        'schemat' => 'organigramm',
        'przeglad' => 'ueberblick',
    ];

    /** @var array<string, string> */
    private const DE_TO_PL = [
        'verzeichnis' => 'kartoteka',
        'organigramm' => 'schemat',
        'ueberblick' => 'przeglad',
    ];

    /**
     * Pierwszy segment ścieżki: `pl`, `en`, `es`, `fr` lub `de`.
     *
     * @return 'pl'|'en'|'es'|'fr'|'de'|null
     */
    public static function siteLocalePrefix(?Request $request = null): ?string
    {
        $request ??= request();
        $s = $request->segment(1);

        if (AppUrl::isUiLocale((string) $s)) {
            return $s;
        }

        return null;
    }

    /**
     * @return array{pl: string|null, en: string|null, es: string|null, fr: string|null}
     */
    public static function forCurrentRoute(): array
    {
        $route = Route::current();
        $name = $route?->getName();
        $params = $route?->parameters() ?? [];

        return [
            'pl' => self::plUrl($name, $params),
            'en' => self::enUrl($name, $params),
            'es' => self::esUrl($name, $params),
            'fr' => self::frUrl($name, $params),
        ];
    }

    /**
     * @param  array<string, mixed>  $params
     */
    private static function plUrl(?string $name, array $params): ?string
    {
        $schematQs = request()->only('pracownik', 'szukaj');

        return match ($name) {
            'home', 'pl.landing', 'en.landing', 'es.landing', 'fr.landing', 'de.landing' => route('pl.landing'),
            'pl.landing.funkcja', 'en.landing.funkcja', 'es.landing.funkcja', 'fr.landing.funkcja', 'de.landing.funkcja', 'landing.funkcja' => isset($params['slug'])
                ? route('pl.landing.funkcja', ['slug' => self::normalizePlSlug((string) $name, (string) $params['slug'])])
                : route('pl.landing'),
            'pl.polityka-prywatnosci', 'en.privacy', 'es.privacy', 'fr.privacy', 'de.privacy', 'polityka-prywatnosci' => route('pl.polityka-prywatnosci'),
            'pl.regulamin', 'en.terms', 'es.terms', 'fr.terms', 'de.terms', 'regulamin' => route('pl.regulamin'),
            'pl.rejestracja', 'en.rejestracja', 'es.rejestracja', 'fr.rejestracja', 'de.rejestracja', 'rejestracja' => route('pl.rejestracja', ['plan' => self::normalizeRegistrationPlan(request()->query('plan'))]),
            'pl.cennik', 'en.cennik', 'es.cennik', 'fr.cennik', 'de.cennik', 'cennik' => route('pl.cennik'),
            'pl.schemat', 'en.schemat', 'es.schemat', 'fr.schemat', 'de.schemat', 'schemat' => route('pl.schemat', $schematQs),
            'pl.przeglad', 'en.przeglad', 'es.przeglad', 'fr.przeglad', 'de.przeglad', 'przeglad' => route('pl.przeglad'),
            'pl.login', 'en.login', 'es.login', 'fr.login', 'de.login', 'login' => route('pl.login'),
            default => null,
        };
    }

    /**
     * @param  array<string, mixed>  $params
     */
    private static function enUrl(?string $name, array $params): ?string
    {
        $schematQs = request()->only('pracownik', 'szukaj');

        return match ($name) {
            'home', 'pl.landing', 'en.landing', 'es.landing', 'fr.landing', 'de.landing' => route('en.landing'),
            'pl.landing.funkcja', 'en.landing.funkcja', 'es.landing.funkcja', 'fr.landing.funkcja', 'de.landing.funkcja', 'landing.funkcja' => isset($params['slug'])
                ? route('en.landing.funkcja', ['slug' => self::normalizeEnSlug((string) $name, (string) $params['slug'])])
                : route('en.landing'),
            'pl.polityka-prywatnosci', 'en.privacy', 'es.privacy', 'fr.privacy', 'de.privacy', 'polityka-prywatnosci' => route('en.privacy'),
            'pl.regulamin', 'en.terms', 'es.terms', 'fr.terms', 'de.terms', 'regulamin' => route('en.terms'),
            'pl.rejestracja', 'en.rejestracja', 'es.rejestracja', 'fr.rejestracja', 'de.rejestracja', 'rejestracja' => route('en.rejestracja', ['plan' => self::normalizeRegistrationPlan(request()->query('plan'))]),
            'pl.cennik', 'en.cennik', 'es.cennik', 'fr.cennik', 'de.cennik', 'cennik' => route('en.cennik'),
            'pl.schemat', 'en.schemat', 'es.schemat', 'fr.schemat', 'de.schemat', 'schemat' => route('en.schemat', $schematQs),
            'pl.przeglad', 'en.przeglad', 'es.przeglad', 'fr.przeglad', 'de.przeglad', 'przeglad' => route('en.przeglad'),
            'pl.login', 'en.login', 'es.login', 'fr.login', 'de.login', 'login' => route('en.login'),
            default => null,
        };
    }

    /**
     * @param  array<string, mixed>  $params
     */
    private static function esUrl(?string $name, array $params): ?string
    {
        $schematQs = request()->only('pracownik', 'szukaj');

        return match ($name) {
            'home', 'pl.landing', 'en.landing', 'es.landing', 'fr.landing', 'de.landing' => route('es.landing'),
            'pl.landing.funkcja', 'en.landing.funkcja', 'es.landing.funkcja', 'fr.landing.funkcja', 'de.landing.funkcja', 'landing.funkcja' => isset($params['slug'])
                ? route('es.landing.funkcja', ['slug' => self::normalizeEsSlug((string) $name, (string) $params['slug'])])
                : route('es.landing'),
            'pl.polityka-prywatnosci', 'en.privacy', 'es.privacy', 'fr.privacy', 'de.privacy', 'polityka-prywatnosci' => route('es.privacy'),
            'pl.regulamin', 'en.terms', 'es.terms', 'fr.terms', 'de.terms', 'regulamin' => route('es.terms'),
            'pl.rejestracja', 'en.rejestracja', 'es.rejestracja', 'fr.rejestracja', 'de.rejestracja', 'rejestracja' => route('es.rejestracja', ['plan' => self::normalizeRegistrationPlan(request()->query('plan'))]),
            'pl.cennik', 'en.cennik', 'es.cennik', 'fr.cennik', 'de.cennik', 'cennik' => route('es.cennik'),
            'pl.schemat', 'en.schemat', 'es.schemat', 'fr.schemat', 'de.schemat', 'schemat' => route('es.schemat', $schematQs),
            'pl.przeglad', 'en.przeglad', 'es.przeglad', 'fr.przeglad', 'de.przeglad', 'przeglad' => route('es.przeglad'),
            'pl.login', 'en.login', 'es.login', 'fr.login', 'de.login', 'login' => route('es.login'),
            default => null,
        };
    }

    /**
     * @param  array<string, mixed>  $params
     */
    private static function frUrl(?string $name, array $params): ?string
    {
        $schematQs = request()->only('pracownik', 'szukaj');

        return match ($name) {
            'home', 'pl.landing', 'en.landing', 'es.landing', 'fr.landing', 'de.landing' => route('fr.landing'),
            'pl.landing.funkcja', 'en.landing.funkcja', 'es.landing.funkcja', 'fr.landing.funkcja', 'de.landing.funkcja', 'landing.funkcja' => isset($params['slug'])
                ? route('fr.landing.funkcja', ['slug' => self::normalizeFrSlug((string) $name, (string) $params['slug'])])
                : route('fr.landing'),
            'pl.polityka-prywatnosci', 'en.privacy', 'es.privacy', 'fr.privacy', 'de.privacy', 'polityka-prywatnosci' => route('fr.privacy'),
            'pl.regulamin', 'en.terms', 'es.terms', 'fr.terms', 'de.terms', 'regulamin' => route('fr.terms'),
            'pl.rejestracja', 'en.rejestracja', 'es.rejestracja', 'fr.rejestracja', 'de.rejestracja', 'rejestracja' => route('fr.rejestracja', ['plan' => self::normalizeRegistrationPlan(request()->query('plan'))]),
            'pl.cennik', 'en.cennik', 'es.cennik', 'fr.cennik', 'de.cennik', 'cennik' => route('fr.cennik'),
            'pl.schemat', 'en.schemat', 'es.schemat', 'fr.schemat', 'de.schemat', 'schemat' => route('fr.schemat', $schematQs),
            'pl.przeglad', 'en.przeglad', 'es.przeglad', 'fr.przeglad', 'de.przeglad', 'przeglad' => route('fr.przeglad'),
            'pl.login', 'en.login', 'es.login', 'fr.login', 'de.login', 'login' => route('fr.login'),
            default => null,
        };
    }

    /**
     * @param  array<string, mixed>  $params
     */
    private static function deUrl(?string $name, array $params): ?string
    {
        $schematQs = request()->only('pracownik', 'szukaj');

        return match ($name) {
            'home', 'pl.landing', 'en.landing', 'es.landing', 'fr.landing', 'de.landing' => route('de.landing'),
            'pl.landing.funkcja', 'en.landing.funkcja', 'es.landing.funkcja', 'fr.landing.funkcja', 'de.landing.funkcja', 'landing.funkcja' => isset($params['slug'])
                ? route('de.landing.funkcja', ['slug' => self::normalizeDeSlug((string) $name, (string) $params['slug'])])
                : route('de.landing'),
            'pl.polityka-prywatnosci', 'en.privacy', 'es.privacy', 'fr.privacy', 'de.privacy', 'polityka-prywatnosci' => route('de.privacy'),
            'pl.regulamin', 'en.terms', 'es.terms', 'fr.terms', 'de.terms', 'regulamin' => route('de.terms'),
            'pl.rejestracja', 'en.rejestracja', 'es.rejestracja', 'fr.rejestracja', 'de.rejestracja', 'rejestracja' => route('de.rejestracja', ['plan' => self::normalizeRegistrationPlan(request()->query('plan'))]),
            'pl.cennik', 'en.cennik', 'es.cennik', 'fr.cennik', 'de.cennik', 'cennik' => route('de.cennik'),
            'pl.schemat', 'en.schemat', 'es.schemat', 'fr.schemat', 'de.schemat', 'schemat' => route('de.schemat', $schematQs),
            'pl.przeglad', 'en.przeglad', 'es.przeglad', 'fr.przeglad', 'de.przeglad', 'przeglad' => route('de.przeglad'),
            'pl.login', 'en.login', 'es.login', 'fr.login', 'de.login', 'login' => route('de.login'),
            default => null,
        };
    }

    private static function normalizePlSlug(string $routeName, string $slug): string
    {
        if ($routeName === 'en.landing.funkcja') {
            return self::EN_TO_PL[$slug] ?? $slug;
        }
        if ($routeName === 'es.landing.funkcja') {
            return self::ES_TO_PL[$slug] ?? $slug;
        }
        if ($routeName === 'fr.landing.funkcja') {
            return self::FR_TO_PL[$slug] ?? $slug;
        }
        if ($routeName === 'de.landing.funkcja') {
            return self::DE_TO_PL[$slug] ?? $slug;
        }

        return $slug;
    }

    private static function normalizeEnSlug(string $routeName, string $slug): string
    {
        if ($routeName === 'pl.landing.funkcja' || $routeName === 'landing.funkcja') {
            return self::PL_TO_EN[$slug] ?? $slug;
        }
        if ($routeName === 'es.landing.funkcja') {
            $internal = self::ES_TO_PL[$slug] ?? $slug;

            return self::PL_TO_EN[$internal] ?? $slug;
        }
        if ($routeName === 'fr.landing.funkcja') {
            $internal = self::FR_TO_PL[$slug] ?? $slug;

            return self::PL_TO_EN[$internal] ?? $slug;
        }
        if ($routeName === 'de.landing.funkcja') {
            $internal = self::DE_TO_PL[$slug] ?? $slug;

            return self::PL_TO_EN[$internal] ?? $slug;
        }

        return $slug;
    }

    private static function normalizeEsSlug(string $routeName, string $slug): string
    {
        if ($routeName === 'pl.landing.funkcja' || $routeName === 'landing.funkcja') {
            return self::PL_TO_ES[$slug] ?? $slug;
        }
        if ($routeName === 'en.landing.funkcja') {
            $internal = self::EN_TO_PL[$slug] ?? $slug;

            return self::PL_TO_ES[$internal] ?? $slug;
        }
        if ($routeName === 'fr.landing.funkcja') {
            $internal = self::FR_TO_PL[$slug] ?? $slug;

            return self::PL_TO_ES[$internal] ?? $slug;
        }
        if ($routeName === 'de.landing.funkcja') {
            $internal = self::DE_TO_PL[$slug] ?? $slug;

            return self::PL_TO_ES[$internal] ?? $slug;
        }

        return $slug;
    }

    private static function normalizeFrSlug(string $routeName, string $slug): string
    {
        if ($routeName === 'pl.landing.funkcja' || $routeName === 'landing.funkcja') {
            return self::PL_TO_FR[$slug] ?? $slug;
        }
        if ($routeName === 'en.landing.funkcja') {
            $internal = self::EN_TO_PL[$slug] ?? $slug;

            return self::PL_TO_FR[$internal] ?? $slug;
        }
        if ($routeName === 'es.landing.funkcja') {
            $internal = self::ES_TO_PL[$slug] ?? $slug;

            return self::PL_TO_FR[$internal] ?? $slug;
        }
        if ($routeName === 'de.landing.funkcja') {
            $internal = self::DE_TO_PL[$slug] ?? $slug;

            return self::PL_TO_FR[$internal] ?? $slug;
        }

        return $slug;
    }

    private static function normalizeDeSlug(string $routeName, string $slug): string
    {
        if ($routeName === 'pl.landing.funkcja' || $routeName === 'landing.funkcja') {
            return self::PL_TO_DE[$slug] ?? $slug;
        }
        if ($routeName === 'en.landing.funkcja') {
            $internal = self::EN_TO_PL[$slug] ?? $slug;

            return self::PL_TO_DE[$internal] ?? $slug;
        }
        if ($routeName === 'es.landing.funkcja') {
            $internal = self::ES_TO_PL[$slug] ?? $slug;

            return self::PL_TO_DE[$internal] ?? $slug;
        }
        if ($routeName === 'fr.landing.funkcja') {
            $internal = self::FR_TO_PL[$slug] ?? $slug;

            return self::PL_TO_DE[$internal] ?? $slug;
        }

        return $slug;
    }

    private static function normalizeRegistrationPlan(mixed $plan): string
    {
        return in_array($plan, ['free', 'full'], true) ? (string) $plan : 'free';
    }

    public static function homeUrl(): string
    {
        return match (self::siteLocalePrefix()) {
            'en' => route('en.landing'),
            'es' => route('es.landing'),
            'fr' => route('fr.landing'),
            'de' => route('de.landing'),
            'pl' => route('pl.landing'),
            default => route('pl.landing'),
        };
    }

    public static function cennikUrl(): string
    {
        return match (self::siteLocalePrefix()) {
            'en' => route('en.cennik'),
            'es' => route('es.cennik'),
            'fr' => route('fr.cennik'),
            'de' => route('de.cennik'),
            'pl' => route('pl.cennik'),
            default => route('pl.cennik'),
        };
    }

    public static function loginUrl(): string
    {
        return match (self::siteLocalePrefix()) {
            'en' => route('en.login'),
            'es' => route('es.login'),
            'fr' => route('fr.login'),
            'de' => route('de.login'),
            'pl' => route('pl.login'),
            default => route('pl.login'),
        };
    }

    public static function appSchematUrl(): string
    {
        return match (self::siteLocalePrefix()) {
            'en' => route('en.schemat'),
            'es' => route('es.schemat'),
            'fr' => route('fr.schemat'),
            'de' => route('de.schemat'),
            'pl' => route('pl.schemat'),
            default => route('pl.schemat'),
        };
    }

    public static function policyUrl(): string
    {
        return match (self::siteLocalePrefix()) {
            'en' => route('en.privacy'),
            'es' => route('es.privacy'),
            'fr' => route('fr.privacy'),
            'de' => route('de.privacy'),
            'pl' => route('pl.polityka-prywatnosci'),
            default => match (app()->getLocale()) {
                'en' => route('en.privacy'),
                'es' => route('es.privacy'),
                'fr' => route('fr.privacy'),
                'de' => route('de.privacy'),
                default => route('pl.polityka-prywatnosci'),
            },
        };
    }

    public static function termsUrl(): string
    {
        return match (self::siteLocalePrefix()) {
            'en' => route('en.terms'),
            'es' => route('es.terms'),
            'fr' => route('fr.terms'),
            'de' => route('de.terms'),
            'pl' => route('pl.regulamin'),
            default => match (app()->getLocale()) {
                'en' => route('en.terms'),
                'es' => route('es.terms'),
                'fr' => route('fr.terms'),
                'de' => route('de.terms'),
                default => route('pl.regulamin'),
            },
        };
    }

    public static function contactFormAction(): string
    {
        return match (self::siteLocalePrefix()) {
            'en' => route('en.landing.contact'),
            'es' => route('es.landing.contact'),
            'fr' => route('fr.landing.contact'),
            'de' => route('de.landing.contact'),
            'pl' => route('pl.landing.kontakt'),
            default => match (app()->getLocale()) {
                'en' => route('en.landing.contact'),
                'es' => route('es.landing.contact'),
                'fr' => route('fr.landing.contact'),
                'de' => route('de.landing.contact'),
                default => route('pl.landing.kontakt'),
            },
        };
    }

    public static function cookieConsentUrl(): string
    {
        return match (self::siteLocalePrefix()) {
            'en' => route('en.cookie.consent'),
            'es' => route('es.cookie.consent'),
            'fr' => route('fr.cookie.consent'),
            'de' => route('de.cookie.consent'),
            'pl' => route('pl.cookie.consent'),
            default => match (app()->getLocale()) {
                'en' => route('en.cookie.consent'),
                'es' => route('es.cookie.consent'),
                'fr' => route('fr.cookie.consent'),
                'de' => route('de.cookie.consent'),
                default => route('pl.cookie.consent'),
            },
        };
    }

    public static function featureAnchorUrl(string $fragment): string
    {
        $base = self::homeUrl();

        return $base.(str_starts_with($fragment, '#') ? $fragment : '#'.$fragment);
    }

    public static function funkcjaUrl(string $internalSlug): string
    {
        if (! isset(self::PL_TO_EN[$internalSlug])) {
            return self::homeUrl();
        }

        return match (self::siteLocalePrefix()) {
            'en' => route('en.landing.funkcja', ['slug' => self::PL_TO_EN[$internalSlug]]),
            'es' => route('es.landing.funkcja', ['slug' => self::PL_TO_ES[$internalSlug]]),
            'fr' => route('fr.landing.funkcja', ['slug' => self::PL_TO_FR[$internalSlug]]),
            'de' => route('de.landing.funkcja', ['slug' => self::PL_TO_DE[$internalSlug]]),
            default => route('pl.landing.funkcja', ['slug' => $internalSlug]),
        };
    }

    /**
     * @return 'pl'|'en'|'es'|'fr'|'de'
     */
    public static function registrationSiteLocale(?Request $request = null): string
    {
        $request ??= request();
        $prefix = self::siteLocalePrefix($request);
        if ($prefix === 'en' || $prefix === 'es' || $prefix === 'pl' || $prefix === 'fr' || $prefix === 'de') {
            return $prefix;
        }

        $name = $request->route()?->getName();
        if (is_string($name)) {
            if (str_starts_with($name, 'en.')) {
                return 'en';
            }
            if (str_starts_with($name, 'es.')) {
                return 'es';
            }
            if (str_starts_with($name, 'fr.')) {
                return 'fr';
            }
            if (str_starts_with($name, 'de.')) {
                return 'de';
            }
            if (str_starts_with($name, 'pl.')) {
                return 'pl';
            }
        }

        $loc = app()->getLocale();

        return in_array($loc, ['en', 'es', 'fr', 'de'], true) ? $loc : 'pl';
    }

    /**
     * @param  'free'|'full'  $plan
     */
    public static function rejestracjaUrl(string $plan = 'free'): string
    {
        $plan = in_array($plan, ['free', 'full'], true) ? $plan : 'free';
        $loc = self::registrationSiteLocale();

        return route($loc.'.rejestracja', ['plan' => $plan]);
    }

    public static function rejestracjaStoreRouteName(): string
    {
        return self::registrationSiteLocale().'.rejestracja.store';
    }

    public static function registrationBackUrl(): string
    {
        $loc = self::registrationSiteLocale();

        return route($loc.'.cennik');
    }

    /** @deprecated Użyj {@see siteLocalePrefix()} === 'en' */
    public static function requestPathUsesEnglishPrefix(?Request $request = null): bool
    {
        return self::siteLocalePrefix($request) === 'en';
    }

    /**
     * @deprecated Użyj {@see registrationSiteLocale()} === 'en'
     */
    public static function registrationUsesEnglishSite(?Request $request = null): bool
    {
        return self::registrationSiteLocale($request) === 'en';
    }
}
