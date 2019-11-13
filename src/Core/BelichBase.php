<?php

namespace Daguilarm\Belich\Core;

use Daguilarm\Belich\Core\Search;
use Daguilarm\Belich\Facades\Helper;
use Illuminate\Support\Str;

abstract class BelichBase
{
    /**
     * Get the resource $accessToResource variable.
     *
     * @return bool
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
     * Set the class name
     *
     * @return string
     */
    public static function className(): string
    {
        $result = request()->query('resourceName') ?? static::resourceName();

        return static::classFormat($result);
    }

    /**
     * Set the class name
     *
     * @param string $className
     *
     * @return string
     */
    public static function classFormat(string $className): string
    {
        return Str::title(Str::singular($className));
    }

    /**
     * Get the resource $downloable variable.
     *
     * @return string
     */
    public static function downloable(): string
    {
        $class = static::resourceClassPath();

        return $class::$downloable;
    }

    /**
     * Init the current class
     *
     * @return object
     */
    public function initResourceClass(): object
    {
        //Set the initial class
        $class = static::resourceClassPath();

        return new $class();
    }

    /**
     * Get the resource $redirectTo variable.
     *
     * @return string
     */
    public static function redirectTo(): string
    {
        $class = static::resourceClassPath();

        return $class::$redirectTo;
    }

    /**
     * Get the resource name ['users', 'billings',...]
     *
     * @return string
     */
    public static function resource(): string
    {
        return app(Search::class)->requestFromSearch()
            //Search action
            ? Helper::stringPluralLower(request()->query('resourceName'))
            //Return middle item from the array
            : static::route()[1] ?? '';
    }

    /**
     * Get the current resource class path
     *
     * @param string|null $className
     *
     * @return string
     */
    public static function resourceClassPath(?string $className = null): string
    {
        $class = $className ?? static::className();

        return '\\App\\Belich\\Resources\\' . static::classFormat($class);
    }

    /**
     * Get the current resource class name: User
     *
     * @return string
     */
    public static function resourceName(): string
    {
        $className = Str::singular(static::resource());

        return Str::title($className);
    }

    /**
     * Get the resource id
     *
     * @return int|null
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
     * Get the resource url.
     *
     * @return string
     */
    public static function resourceUrl(): string
    {
        return static::url() . '/' . static::resource();
    }

    /**
     * Set the table text align
     * Used by getResourceOnlyWithNavigationFields() in Core\Traits\Resourceable
     *
     * @param string $class
     *
     * @return string
     */
    public function setTableTextAlign(string $class): string
    {
        //Get the resource value
        $align = $class::$tableTextAlign ?? null;

        //Validate the value
        return in_array($align, ['left', 'center', 'right', 'justify'])
            ? 'text-' . $align
            : 'text-left';
    }
}
