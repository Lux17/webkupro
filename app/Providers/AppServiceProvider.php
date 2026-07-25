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
        // Never expose debug stack traces outside local/testing environments.
        if (! app()->environment(['local', 'testing'])) {
            config(['app.debug' => false]);
        }
    }
}
