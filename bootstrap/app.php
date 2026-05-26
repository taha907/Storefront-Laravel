<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\ForceHttpsMiddleware;
use App\Http\Middleware\SessionDiagnosticsMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        // LARAVEL 11 PROXY AYARI: Render üzerindeki HTTPS kilitlenmesini çözer
        $middleware->trustProxies(at: '*');

        // Render'da bazen ilk istek HTTP gelebiliyor; Secure session cookie yazılmadığı için 419 oluşuyor.
        // Production'da her isteği HTTPS'e zorla.
        $middleware->append(ForceHttpsMiddleware::class);

        // Render'da 419 kök nedenini yakalamak için opsiyonel teşhis.
        // Render Environment'a SESSION_DIAGNOSTICS=true eklenince log'a fingerprint basar.
        $middleware->append(SessionDiagnosticsMiddleware::class);
        
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();