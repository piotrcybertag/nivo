<?php

namespace App\Support;

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
    private const EN_TO_PL = [
        'directory' => 'kartoteka',
        'org-chart' => 'schemat',
        'overview' => 'przeglad',
    ];

    /**
     * @return array{pl: string|null, en: string|null}
     */
    public static function forCurrentRoute(): array
    {
        $route = Route::current();
        $name = $route?->getName();
        $params = $route?->parameters() ?? [];

        return [
            'pl' => self::plUrl($name, $params),
            'en' => self::enUrl($name, $params),
        ];
    }

    /**
     * @param  array<string, mixed>  $params
     */
    private static function plUrl(?string $name, array $params): ?string
    {
        return match ($name) {
            'home', 'en.landing' => route('home'),
            'landing.funkcja', 'en.landing.funkcja' => isset($params['slug'])
                ? route('landing.funkcja', ['slug' => self::normalizePlSlug((string) $name, (string) $params['slug'])])
                : route('home'),
            'polityka-prywatnosci', 'en.privacy' => route('polityka-prywatnosci'),
            'regulamin', 'en.terms' => route('regulamin'),
            default => null,
        };
    }

    /**
     * @param  array<string, mixed>  $params
     */
    private static function enUrl(?string $name, array $params): ?string
    {
        return match ($name) {
            'home', 'en.landing' => route('en.landing'),
            'landing.funkcja', 'en.landing.funkcja' => isset($params['slug'])
                ? route('en.landing.funkcja', ['slug' => self::normalizeEnSlug((string) $name, (string) $params['slug'])])
                : route('en.landing'),
            'polityka-prywatnosci', 'en.privacy' => route('en.privacy'),
            'regulamin', 'en.terms' => route('en.terms'),
            default => null,
        };
    }

    private static function normalizePlSlug(string $routeName, string $slug): string
    {
        if ($routeName === 'en.landing.funkcja') {
            return self::EN_TO_PL[$slug] ?? $slug;
        }

        return $slug;
    }

    private static function normalizeEnSlug(string $routeName, string $slug): string
    {
        if ($routeName === 'landing.funkcja') {
            return self::PL_TO_EN[$slug] ?? $slug;
        }

        return $slug;
    }

    public static function homeUrl(): string
    {
        return app()->getLocale() === 'en' ? route('en.landing') : route('home');
    }

    public static function policyUrl(): string
    {
        return app()->getLocale() === 'en' ? route('en.privacy') : route('polityka-prywatnosci');
    }

    public static function termsUrl(): string
    {
        return app()->getLocale() === 'en' ? route('en.terms') : route('regulamin');
    }

    public static function contactFormAction(): string
    {
        return app()->getLocale() === 'en' ? route('en.landing.contact') : route('landing.kontakt');
    }

    public static function cookieConsentUrl(): string
    {
        return app()->getLocale() === 'en' ? route('en.cookie.consent') : route('cookie.consent');
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

        if (app()->getLocale() === 'en') {
            return route('en.landing.funkcja', ['slug' => self::PL_TO_EN[$internalSlug]]);
        }

        return route('landing.funkcja', ['slug' => $internalSlug]);
    }
}
