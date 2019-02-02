<?php

namespace Daguilarm\Belich\Core;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

class BelichHelpers {

    /** @var string */
    private static $version = '1.0.0';

    /*
    |--------------------------------------------------------------------------
    | Public Static Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Get the app name.
     *
     * @return string
     */
    public static function version() : string
    {
        return static::$version;
    }

    /**
     * Get the app name.
     *
     * @return string
     */
    public static function name() : string
    {
        return config('belich.name', 'Belich Dashboard');
    }

    /**
     * Get the app path.
     *
     * @return string
     */
    public static function path() : string
    {
        return config('belich.path', '/dashboard');
    }

    /**
     * Set the app url.
     *
     * @return string
     */
    public static function url() : string
    {
        return Request::root() . static::path();
    }

    /**
     * Set the app url.
     *
     * @return string
     */
    public static function resourceUrl() : string
    {
        return static::url() . '/' . static::resource();
    }

    /**
     * Get Controller action ['index', 'edit', 'create' or 'show'] from the route
     *
     * @return string
     */
    public static function action() : string
    {
        //Cannot pass directly as reference!!
        $route = static::route();

        //Return last item from the array
        return end($route);
    }

    /**
     * Get the resource name ['users', 'billings',...]
     *
     * @return string
     */
    public static function resource() : string
    {
        //Return middle item from the array
        return static::route()[1];
    }

    /**
     * Get the resource numeric id
     *
     * @return int
     */
    public static function resourceId()
    {
        $resource = Str::singular(static::resource());

        return Request::route($resource) ?? null;
    }

    /**
     * Get the current resource class name: User
     *
     * @return string
     */
    public static function resourceClassName() : string
    {
        $className = Str::singular(static::resource());

        return Str::title($className);
    }

    /*
    |--------------------------------------------------------------------------
    | Auxiliar Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Get route divided in arrays
     * will return an array like: ['dashboard', 'users', 'index']
     *
     * @return array
     */
    public static function route() : array
    {
        //Get route name
        return explode('.', Request::route()->getName());
    }

    /**
     * Get the current resource class path
     *
     * @return string
     */
    public static function resourceClassPath($className = null) : string
    {
        if($className) {
            $className = Str::title(Str::singular($className));
        }

        return '\\App\\Belich\\Resources\\' . ($className ?? static::resourceClassName());
    }
}
