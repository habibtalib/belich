<?php

namespace Daguilarm\Belich;

use Daguilarm\Belich\Core\Helpers;
use Illuminate\Http\Request;

abstract class Resources {

    use Helpers;

    /** @var bool */
    public static $accessToResource = true;

    /** @var string */
    public static $actions = 'default';

    /** @var bool */
    public static $displayInNavigation = true;

    /** @var bool */
    public static $downloable = false;

    /** @var Illuminate\Support\Collection */
    public static $fields;

    /** @var string */
    public static $group;

    /** @var string */
    public static $icon;

    /** @var string */
    public static $label;

    /** @var string [Model path] */
    public static $model;

    /** @var string */
    public static $pluralLabel;

    /** @var string */
    public static $redirectTo = 'index';

    /** @var array */
    public static $relationships;

    /** @var array */
    public static $softDeletes = false;

    /** @var bool [Show with tabs] */
    public static $tabs;

    /**
     * Get the fields displayed by the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    abstract public function fields(Request $request);

    /**
     * Set the custom cards
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Illuminate\Support\Collection
     */
    abstract public static function cards(Request $request);

    /**
     * Set the custom metrics cards
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Illuminate\Support\Collection
     */
    abstract public static function metrics(Request $request);

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

        //Set show
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
    public static function actions()
    {
        return [
            Utils::icon('eye')   => Utils::route('show'),
            Utils::icon('edit')  => Utils::route('edit'),
            Utils::icon('trash') => Utils::route('destroy'),
        ];
    }
}
