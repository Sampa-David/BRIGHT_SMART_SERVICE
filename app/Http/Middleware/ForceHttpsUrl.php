<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceHttpsUrl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Trust proxied headers from Railway, Render, Heroku, etc.
        if ($this->isProxiedConnection($request)) {
            $request->setTrustedProxies(
                [$request->server('REMOTE_ADDR')],
                Request::HEADER_X_FORWARDED_FOR |
                Request::HEADER_X_FORWARDED_HOST |
                Request::HEADER_X_FORWARDED_PROTO |
                Request::HEADER_X_FORWARDED_PORT
            );

            // Force HTTPS scheme detection
            if ($request->header('X-Forwarded-Proto') === 'https') {
                $_SERVER['HTTPS'] = 'on';
                $request->server->set('HTTPS', 'on');
            }
        }

        return $next($request);
    }

    /**
     * Determine if the request is from a proxied service.
     */
    private function isProxiedConnection(Request $request): bool
    {
        $proxiedHeaders = [
            'X-Forwarded-For',
            'X-Forwarded-Host',
            'X-Forwarded-Proto',
            'CF-Connecting-IP', // Cloudflare
        ];

        foreach ($proxiedHeaders as $header) {
            if ($request->header($header)) {
                return true;
            }
        }

        return false;
    }
}
