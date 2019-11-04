<?php

namespace Daguilarm\Belich\Core\Traits;

trait Modelable
{
    /**
     * Get the resource model instance.
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public static function getModel(): object
    {
        return app(static::getModelPath());
    }

    /**
     * Get the resource model path.
     *
     * @return string
     */
    public static function getModelPath(): string
    {
        $resourceClass = static::resourceClassPath();

        return $resourceClass::$model;
    }

    /**
     * Get the resource model key name.
     *
     * @return string
     */
    public static function getModelKeyName(): string
    {
        return static::getModel()->getKeyName();
    }
}
