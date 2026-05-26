<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class SessionDiagnosticsMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (env('SESSION_DIAGNOSTICS', false)) {
            $key = (string) config('app.key', '');
            $keyFingerprint = $key === '' ? 'missing' : substr(hash('sha256', $key), 0, 12);

            $sessionCookieName = (string) config('session.cookie');
            $hasSessionCookie = $request->cookies->has($sessionCookieName);

            Log::info('session-diag', [
                'method' => $request->method(),
                'path' => $request->path(),
                'secure' => $request->isSecure(),
                'host' => $request->getHost(),
                'app_env' => (string) config('app.env'),
                'app_url' => (string) config('app.url'),
                'session_driver' => (string) config('session.driver'),
                'session_cookie' => $sessionCookieName,
                'has_session_cookie' => $hasSessionCookie,
                'session_id' => $request->hasSession() ? (string) $request->session()->getId() : null,
                'has_csrf_input' => $request->request->has('_token'),
                'csrf_input_len' => $request->request->has('_token') ? strlen((string) $request->input('_token')) : 0,
                'key_fp' => $keyFingerprint,
                'status' => $response->getStatusCode(),
            ]);
        }

        return $response;
    }
}

