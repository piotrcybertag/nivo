<?php

namespace App\Http\Middleware;

use App\Support\AdminLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogAdminAudit
{
    public function handle(Request $request, Closure $next, string $action = 'landing'): Response
    {
        $response = $next($request);

        if (! config('admin_audit.enabled', true)) {
            return $response;
        }

        match ($action) {
            'landing' => AdminLog::landingVisit($request),
            'registration_open' => AdminLog::registrationPageOpen($request),
            default => null,
        };

        return $response;
    }
}
