<?php

declare(strict_types=1);

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
     */
    public static function getModelPath(): string
    {
        $resourceClass = static::resourceClassPath();

        return $resourceClass::$model;
    }

    /**
     * Get the resource model key name.
     */
    public static function getModelKeyName(): string
    {
        return static::getModel()->getKeyName();
    }
}
