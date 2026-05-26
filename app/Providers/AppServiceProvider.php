<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;

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
        // 1. RENDER PROXY AYARI: Gelen tüm isteklerin güvenli (HTTPS) proxy'den geldiğini Laravel'e bildirir.
        Request::setTrustedProxies(
            ['0.0.0.0/0', '2a00:1450:4000::/36'], // Tüm IP aralıklarına güven (Render için şart)
            Request::HEADER_X_FORWARDED_FOR | 
            Request::HEADER_X_FORWARDED_HOST | 
            Request::HEADER_X_FORWARDED_PORT | 
            Request::HEADER_X_FORWARDED_PROTO
        );

        // 2. HTTPS ZORUNLULUĞU: Canlı ortamda tüm link üretimlerini ve form action'larını https yapar.
        if (config('app.env') === 'production' || config('app.url') !== 'http://localhost') {
            URL::forceScheme('https');
        }
    }
}