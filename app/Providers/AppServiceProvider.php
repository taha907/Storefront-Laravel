<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (config('app.env') === 'production') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // Render: SESSION_DOMAIN=.onrender.com tarayıcıda çerez tutmaz → 419
        $domain = config('session.domain');
        if (is_string($domain) && $domain !== '' && str_contains($domain, 'onrender.com')) {
            config(['session.domain' => null]);
        }
    }
}
