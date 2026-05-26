<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceHttpsMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (app()->environment('production') && ! $request->secure()) {
            $target = 'https://'.$request->getHttpHost().$request->getRequestUri();

            return redirect()->to($target, 301);
        }

        return $next($request);
    }
}

