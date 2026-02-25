<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdm
{
    public function handle(Request $request, Closure $next): Response
    {
        if (session('uzytkownik_typ') !== 'ADM') {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Brak uprawnień.'], 403);
            }
            return redirect()->route('home')->with('error', 'Dostęp tylko dla administratora (ADM).');
        }

        return $next($request);
    }
}
