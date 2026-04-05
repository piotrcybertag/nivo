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
            'pl_path' => self::pathOnly($alts['pl'] ?? route('pl.landing')),
            'en_path' => self::pathOnly($alts['en'] ?? route('en.landing')),
            'es_path' => self::pathOnly($alts['es'] ?? route('es.landing')),
            'fr_path' => self::pathOnly($alts['fr'] ?? route('fr.landing')),
            'de_path' => self::pathOnly($alts['de'] ?? route('de.landing')),
        ]);
    }

    private static function pathOnly(string $url): string
    {
        $p = parse_url($url, PHP_URL_PATH);

        return ($p === null || $p === '') ? '/' : $p;
    }
}
