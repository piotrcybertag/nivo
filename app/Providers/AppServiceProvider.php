<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $versionFile = base_path('versions.txt');
        $appVersion = (is_file($versionFile) && ($v = trim((string) file_get_contents($versionFile))) !== '')
            ? $v
            : '1';
        View::share('appVersion', $appVersion);
    }
}
