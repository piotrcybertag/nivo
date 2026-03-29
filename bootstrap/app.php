<?php

use App\Http\Middleware\EnsureUserIsAdm;
use App\Http\Middleware\LogAdminAudit;
use App\Http\Middleware\SetLandingLocale;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'landing.locale' => SetLandingLocale::class,
            'uzytkownik.adm' => EnsureUserIsAdm::class,
            'admin.audit' => LogAdminAudit::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
