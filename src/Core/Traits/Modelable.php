<?php

namespace Daguilarm\Belich\Core\Traits;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

trait Modelable
{
    /*
    |--------------------------------------------------------------------------
    | Public Static Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Get the resource model instance.
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public static function getModel()
    {
        return app(static::getModelPath());
    }

    /**
     * Get the resource model path.
     *
     * @return string
     */
    public static function getModelPath() : string
    {
        $resourceClass = static::resourceClassPath();

        return $resourceClass::$model;
    }

    /**
     * Get the resource model key name.
     *
     * @return string
     */
    public static function getModelKeyName() : string
    {
        return static::getModel()->getKeyName();
    }
}
