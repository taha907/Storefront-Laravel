<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        // Render (*.onrender.com): SESSION_DOMAIN=.onrender.com kullanılamaz (Public Suffix).
        // Tarayıcı çerezi kaydetmez → login POST'ta 419 Page Expired.
        $domain = config('session.domain');
        if (is_string($domain) && $domain !== '' && str_contains($domain, 'onrender.com')) {
            config(['session.domain' => null]);
        }
    }
}