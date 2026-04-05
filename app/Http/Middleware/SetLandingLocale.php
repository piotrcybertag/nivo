<?php

namespace App\Http\Middleware;

use App\Support\AppUrl;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLandingLocale
{
    public function handle(Request $request, Closure $next, string $locale = 'pl'): Response
    {
        $locale = AppUrl::isUiLocale($locale) ? $locale : 'pl';
        App::setLocale($locale);

        return $next($request);
    }
}
