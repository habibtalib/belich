<?php

namespace Daguilarm\Belich\Core\Traits;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

trait Models {

    /*
    |--------------------------------------------------------------------------
    | Public Static Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Get the resource model key name.
     *
     * @return string
     */
    public static function getModelKeyName() : string
    {
        return static::getModel()->getKeyName();
    }

    /*
    |--------------------------------------------------------------------------
    | Private Static Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Get the resource model instance.
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    private static function getModel()
    {
        $resourceClass = static::resourceClassPath();

        return app($resourceClass::$model);
    }
}
