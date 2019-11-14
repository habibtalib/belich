<?php

namespace Daguilarm\Belich\App\Http\Middleware;

use Closure;

final class HttpsMiddleware
{
    /**
     * Force to secure URL
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     *
     * @return object
     */
    public function handle($request, Closure $next): object
    {
        if (! $request->secure()) {
            return redirect()->secure($request->getRequestUri());
        }

        return $next($request);
    }
}
