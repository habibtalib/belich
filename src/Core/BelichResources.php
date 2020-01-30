<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Core;

use Daguilarm\Belich\Core\Search\Search;
use Daguilarm\Belich\Facades\Helper;
use Illuminate\Support\Str;

abstract class BelichResources
{
    /**
     * Get the resource $accessToResource variable.
     */
    public static function accessToResource(): bool
    {
        $class = static::resourceClassPath();

        return class_exists($class)
            // This is for the views (like dashboard)
            // which has not a resouce class
            // so don't ever remove!
            ? $class::$accessToResource
            : true;
    }

    /**
     * Init the current class
     */
    public function initResourceClass(): object
    {
        //Set the initial class
        $class = static::resourceClassPath();

        return new $class();
    }

    /**
     * Get the resource name ['users', 'billings',...]
     */
    public static function resource(): string
    {
        return app(Search::class)->searchRequest()
            //Search action
            ? Helper::stringPluralLower(request()->query('resourceName'))
            //Return middle item from the array
            : static::route()[1] ?? '';
    }

    /**
     * Get the current resource class path
     */
    public static function resourceClassPath(?string $className = null): string
    {
        $class = $className ?? static::className();

        return '\\App\\Belich\\Resources\\' . static::classFormat($class);
    }

    /**
     * Get the resource id
     */
    public static function resourceId(): ?int
    {
        $resource = Str::singular(static::resource());
        $resourceId = request()->route($resource) ?? null;

        if (is_null($resourceId)) {
            return null;
        }

        if (is_numeric($resourceId)) {
            return $resourceId;
        }

        throw new \InvalidArgumentException(trans('belich::exceptions.invalid.resourceId'));
    }

    /**
     * Get the current resource class name: User
     */
    public static function resourceName(): string
    {
        $className = Str::singular(static::resource());

        return Str::title($className);
    }

    /**
     * Get the resource url.
     */
    public static function resourceUrl(): string
    {
        return static::url() . '/' . static::resource();
    }
}
