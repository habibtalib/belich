<?php

namespace Daguilarm\Belich;

use Illuminate\Http\Request;

abstract class Resources {

    /** @var Illuminate\Support\Collection */
    public static $actions;

    /** @var Illuminate\Support\Collection */
    public static $breadcrumbs = [

    ];

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

    /**
     * Get the fields displayed by the resource.
     *
     * @param \Illuminate\Http\Request $request
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
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function model() : \Illuminate\Database\Eloquent\Builder
    {
        $model         = static::$model;
        $relationships = static::$relationships;

        return $relationships
            ? app($model)::with($relationships)
            : app($model);
    }
}
