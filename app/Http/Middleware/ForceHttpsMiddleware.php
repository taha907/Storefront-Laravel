<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceHttpsMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! app()->environment('production')) {
            return $next($request);
        }

        $forwarded = strtolower((string) $request->header('X-Forwarded-Proto', ''));
        if ($request->secure() || $forwarded === 'https') {
            return $next($request);
        }

        return redirect()->secure($request->getRequestUri(), 301);
    }
}

