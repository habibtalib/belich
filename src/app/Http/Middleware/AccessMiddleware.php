<?php

namespace Daguilarm\Belich\App\Http\Middleware;

use Closure;
use Daguilarm\Belich\Core\Belich;

class AccessMiddleware
{
    /**
     * Force to secure URL
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     */
    public function handle($request, Closure $next)
    {
        if (Belich::accessToResource() === false) {
            return abort(403);
        }

        return $next($request);
    }
}
