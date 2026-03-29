<?php

namespace App\View\Composers;

use App\Support\LandingAlternateUrls;
use Illuminate\View\View;

class LandingLayoutComposer
{
    public function compose(View $view): void
    {
        $alts = LandingAlternateUrls::forCurrentRoute();
        $view->with('landingAlternateUrls', $alts);
        $view->with('landingLocale', app()->getLocale());
        $view->with('landingLocaleSwitch', [
            'pl_path' => self::pathOnly($alts['pl'] ?? route('home')),
            'en_path' => self::pathOnly($alts['en'] ?? route('en.landing')),
        ]);
    }

    private static function pathOnly(string $url): string
    {
        $p = parse_url($url, PHP_URL_PATH);

        return ($p === null || $p === '') ? '/' : $p;
    }
}
