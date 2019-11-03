<?php

namespace Daguilarm\Belich\App\Http\Middleware;

use Closure;
use Daguilarm\Belich\Core\Belich;
use Illuminate\Support\Facades\Cookie;

class BelichMiddleware
{
    /** @var int */
    private $perPage = 20;

    /** @var string */
    private $withTrashed = 'none';

    /**
     * Force to secure URL
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     */
    public function handle($request, Closure $next)
    {
        // Authorized access to resource
        if (Belich::accessToResource() === false) {
            return abort(403);
        }

        //Set base middleware response
        $response = $next($request);

        // Default results per page cookie
        if (!$request->cookie('belich_perPage')) {
            $response = $response->withCookie(cookie('belich_perPage', $this->perPage, setTimeForCookie()));
        }

        // Default trashed results cookie
        if (!$request->cookie('belich_withTrashed')) {
            $response = $response->withCookie(cookie('belich_withTrashed', $this->withTrashed, setTimeForCookie()));
        }

        return $response;
    }
}
