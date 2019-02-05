<?php

namespace Daguilarm\Belich;

use Daguilarm\Belich\Core\BelichHelpers;
use Illuminate\Http\Request;

abstract class Resources {

    use BelichHelpers;

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
            ? app($model)->with($relationships)
            : app($model);
    }

    /**
     * Default breadcrumb
     *
     * @return array
     */
    public static function breadcrumbs()
    {
        //Default home value
        $home  = [trans('belich::belich.navigation.home') => static::url()];

        //Set index
        if(static::action() === 'index') {
            return array_merge($home,
                [static::$pluralLabel => null]
            );
        }

        //Set edit
        if(static::action() === 'edit') {
            return array_merge($home,
                [static::$label => static::resourceUrl()],
                [trans('belich::buttons.crud.update') => null]
            );
        }

        //Set create
        if(static::action() === 'create') {
            return array_merge($home,
                [static::$label => static::resourceUrl()],
                [trans('belich::buttons.crud.create') => null]
            );
        }

        //Set create
        if(static::action() === 'show') {
            return array_merge($home,
                [static::$label => static::resourceUrl()],
                [trans('belich::buttons.crud.show') => null]
            );
        }

        return $home;
    }

    /**
     * Default actions
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public static function actions(Request $request)
    {
        // return [
        //     Utils::icon('eye')   => routeShow(),
        //     Utils::icon('edit')  => routeEdit(),
        //     Utils::icon('trash') => routeDelete(),
        // ];
    }
}
