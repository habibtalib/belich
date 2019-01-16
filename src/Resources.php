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

    /** @var array [Resource settings] */
    public static $settings = [];

    /** @var array */
    public static $softDeletes = false;

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
    | Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Set the resource model
     *
     * @return object
     */
    public function model() : object
    {
        return app(static::$model);
    }

    /**
     * Set the resource model with relationships. This is the default method for index.
     *
     * @return object
     */
    public function modelWithRelationships() : object
    {
        return self::model()->with(static::$relationships);
    }
}
