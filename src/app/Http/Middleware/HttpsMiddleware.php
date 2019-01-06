<?php

namespace Daguilarm\Belich\App\Http\Middleware;

use Closure;

class HttpsMiddleware
{
    /**
     * Force to secure URL
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     */
    public function handle($request, Closure $next)
    {
        if (!$request->secure()) {
            return redirect()->secure($request->getRequestUri());
        }

        return $next($request);
    }
}
