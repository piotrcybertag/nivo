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
        View::share('appVersion', app()->runningInConsole() ? '1' : $this->readVersion());
    }

    private function readVersion(): string
    {
        try {
            $path = base_path('versions.txt');
            if ($path !== '' && is_file($path) && ($v = file_get_contents($path)) !== false && ($t = trim($v)) !== '') {
                return $t;
            }
        } catch (\Throwable $e) {
        }
        return '1';
    }
}
