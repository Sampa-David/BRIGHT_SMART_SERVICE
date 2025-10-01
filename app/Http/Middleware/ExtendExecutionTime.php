<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ExtendExecutionTime
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Augmenter la limite de temps d'exécution à 5 minutes
        set_time_limit(300);
        
        return $next($request);
    }
}