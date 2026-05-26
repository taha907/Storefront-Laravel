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
        // 1. RENDER PROXY GÜVENLİK AYARI
        // Gelen tüm isteklerin güvenli bir yük dengeleyiciden geldiğini doğrular
        Request::setTrustedProxies(
            ['0.0.0.0/0', '2a00:1450:4000::/36'],
            Request::HEADER_X_FORWARDED_FOR | 
            Request::HEADER_X_FORWARDED_HOST | 
            Request::HEADER_X_FORWARDED_PORT | 
            Request::HEADER_X_FORWARDED_PROTO |
            Request::HEADER_X_FORWARDED_AWS_ELB
        );

        // 2. CANLI ORTAM HTTPS ZORUNLULUĞU
        // Linklerin, form action'larının ve çerezlerin HTTP'ye düşmesini tamamen engeller
        if (config('app.env') === 'production' || config('app.url') !== 'http://localhost') {
            URL::forceScheme('https');
            
            // Laravel'in ürettiği session çerezlerini canlıda HTTPS'e kelepçeliyoruz
            config(['session.secure' => true]);
            config(['session.same_site' => 'lax']);
        }
    }
}