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
        // Configure asset compilation path
        $this->configureAssets();
        
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

    /**
     * Configure asset compilation for Vite.
     */
    private function configureAssets(): void
    {
        // Vite will handle asset versioning automatically
        // In production, ensure public/build/manifest.json exists
        // (created by: npm run build)
    }
}
