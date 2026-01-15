<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectHttpsUrl
{
    /**
     * Handle an incoming request and redirect HTTP to HTTPS in production.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only redirect in production
        if (config('app.env') === 'production' && !$request->secure()) {
            // Check if we're behind a proxy with HTTPS
            if ($request->header('X-Forwarded-Proto') === 'https') {
                // Request is already HTTPS, just continue
                return $next($request);
            }

            // Redirect to HTTPS
            return redirect()->secure($request->path(), 301, [
                'query' => $request->query()
            ]);
        }

        return $next($request);
    }
}
