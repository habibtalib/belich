<?php

namespace Daguilarm\Belich;

use Daguilarm\Belich\Core\Helpers;
use Illuminate\Http\Request;

abstract class Resources {

    /** @var Illuminate\Support\Collection */
    public static $actions;

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
    public function model() : object
    {
        $model         = static::$model;
        $relationships = static::$relationships;

        return $relationships
            ? app($model)::with($relationships)
            : app($model);
    }

    /**
     * Rewriting the default breadcrumb
     *
     * @return Illuminate\Support\Collection
     */
    public static function breadcrumbs() {
        //Default value
        $home  = [trans('belich::belich.navigation.home') => Helpers::url()];

        switch(Helpers::action()) {
            case 'index':
                return array_merge($home,
                    [static::$pluralLabel => null]
                );

            case 'edit':
                return array_merge($home,
                    [static::$pluralLabel => Helpers::resourceUrl()],
                    [trans('belich::belich.buttons.edit') => null]
                );

            case 'create':
                array_merge($home,
                    [static::$pluralLabel => Helpers::resourceUrl()],
                    [trans('belich::belich.buttons.create') => null]
                );

            default:
                return $home;
        }
    }
}
