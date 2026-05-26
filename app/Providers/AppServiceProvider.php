<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        // Eğer uygulama canlı ortamda (Render'da) çalışıyorsa linkleri HTTPS'e zorla
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}