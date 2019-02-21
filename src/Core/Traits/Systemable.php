<?php

namespace Daguilarm\Belich\Core\Traits;

use Illuminate\Support\Facades\Request;

trait Systemable {

    /** @var array */
    private $defaultMiddleware = ['https', 'web', 'auth', 'belich'];

    /*
    |--------------------------------------------------------------------------
    | Public Static Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Get the config middleware
     *
     * @return array
     */
    public static function middleware() : array
    {
        return array_merge(config('belich.middleware'), ['belich']) ?? $this->defaultMiddleware;
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
     * Get the app path name.
     *
     * @return string
     */
    public static function pathName() : string
    {
        return str_replace('/', '', static::path());
    }

    /**
     * Get the app url.
     *
     * @return string
     */
    public static function url() : string
    {
        return Request::root() . static::path();
    }

    /**
     * Get the app version.
     *
     * @return string
     */
    public static function version() : string
    {
        return static::$version;
    }
}
