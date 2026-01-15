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
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
            
            // Configure SSL for PostgreSQL
            if (config('database.default') === 'pgsql') {
                $sslMode = config('database.connections.pgsql.sslmode', 'require');
                config([
                    'database.connections.pgsql.sslmode' => $sslMode
                ]);
            }
        }
    }
}
