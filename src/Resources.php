<?php

namespace Daguilarm\Belich;

use Illuminate\Http\Request;

abstract class Resources {

    /** @var Illuminate\Support\Collection */
    public static $actions;

    /** @var Illuminate\Support\Collection */
    public static $breadcrumb;

    /** @var Illuminate\Support\Collection */
    public static $cards;

    /** @var Illuminate\Support\Collection */
    public static $fields;

    /** @var Illuminate\Support\Collection */
    public static $metrics;

    /** @var string [Model path] */
    public static $model;

    /** @var array */
    public static $relationships;

    /** @var array */
    public static $softDeletes = false;

    /** @var bool [Show the resource on navigation] */
    public static $availableForNavigation = true;

    /**
     * Determine if this resource is available for navigation.
     *
     * @return bool
     */
    private static function resource()
    {
        return getResourceClass();
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    abstract public function fields(Request $request);

    /*
    |--------------------------------------------------------------------------
    | Static methods
    |--------------------------------------------------------------------------
    */

    /**
     * Get the logical group associated with the resource.
     *
     * @return string
     */
    // public static function navigation()
    // {
    //     return static::$navigation;
    // }

    /**
     * Get the displayable plural label of the resource.
     *
     * @return string
     */
    public static function pluralLabel()
    {
        return Str::plural(class_basename(get_called_class()));
    }

    /**
     * Determine if this resource is searchable.
     *
     * @return bool
     */
    public static function searchable()
    {
        return true;
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return Str::singular(static::label());
    }

    /**
     * Determine if this resource uses soft deletes.
     *
     * @return bool
     */
    // public static function softDeletes()
    // {
    // }

    /*
    |--------------------------------------------------------------------------
    | Methods
    |--------------------------------------------------------------------------
    */
    public function model()
    {
        return app(static::$model);
    }

    public function modelWithRelationships()
    {
        return self::model()->with(static::$relationships);
    }
}
