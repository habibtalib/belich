<?php

namespace Daguilarm\Belich\App\Http\Middleware;

use Closure;
use Daguilarm\Belich\Core\Belich;
use Daguilarm\Belich\Facades\Helper;

final class BelichMiddleware
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
     *
     * @return object
     */
    public function handle($request, Closure $next): object
    {
        // Authorized access to resource
        if (Belich::accessToResource() === false) {
            return abort(403);
        }

        //Set base middleware response
        $response = $next($request);

        // Default results per page cookie
        if (! $request->cookie('belich_perPage')) {
            $response = $response->withCookie(cookie('belich_perPage', $this->perPage, Helper::timeForCookie()));
        }

        // Default trashed results cookie
        if (! $request->cookie('belich_withTrashed')) {
            $response = $response->withCookie(cookie('belich_withTrashed', $this->withTrashed, Helper::timeForCookie()));
        }

        return $response;
    }
}
