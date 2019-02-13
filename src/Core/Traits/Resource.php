<?php

namespace Daguilarm\Belich\Core\Traits;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

trait Resource {

    /*
    |--------------------------------------------------------------------------
    | Public Static Methods
    |--------------------------------------------------------------------------
    */

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
     * Get the current resource class path
     *
     * @return string
     */
    public static function resourceClassPath($className = null) : string
    {
        if($className) {
            $className = Str::title(Str::singular($className));
        }

        return '\\App\\Belich\\Resources\\' . ($className ?? static::resourceName());
    }

    /**
     * Get the current resource class name: User
     *
     * @return string
     */
    public static function resourceName() : string
    {
        $className = Str::singular(static::resource());

        return Str::title($className);
    }

    /**
     * Get the resource id
     *
     * @return int
     */
    public static function resourceId()
    {
        $resource = Str::singular(static::resource());
        $resourceId = Request::route($resource) ?? null;

        return is_numeric($resourceId)
            ? $resourceId
            : abort(404);
    }

    /**
     * Get the resource url.
     *
     * @return string
     */
    public static function resourceUrl() : string
    {
        return static::url() . '/' . static::resource();
    }
}
