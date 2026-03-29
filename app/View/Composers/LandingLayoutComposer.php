<?php

namespace App\View\Composers;

use App\Support\LandingAlternateUrls;
use Illuminate\View\View;

class LandingLayoutComposer
{
    public function compose(View $view): void
    {
        $view->with('landingAlternateUrls', LandingAlternateUrls::forCurrentRoute());
        $view->with('landingLocale', app()->getLocale());
    }
}
