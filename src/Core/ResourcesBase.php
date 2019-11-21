<?php

namespace Daguilarm\Belich\Core;

class ResourcesBase
{
    /**
     * @var bool
     */
    public static $accessToResource = true;

    /**
     * @var string
     */
    public static $actions = 'default';

    /**
     * @var bool
     */
    public static $displayInNavigation = true;

    /**
     * @var bool
     */
    public static $downloable = false;

    /**
     * @var Illuminate\Support\Collection
     */
    public static $fields;

    /**
     * @var string
     */
    public static $group;

    /**
     * @var string
     */
    public static $icon;

    /**
     * @var string
     */
    public static $imageCss = 'block h-10 rounded-full shadow-md';

    /**
     * @var string
     */
    public static $label;

    /**
     * Model path
     *
     * @var string
     */
    public static $model;

    /**
     * @var string
     */
    public static $pluralLabel;

    /**
     * @var string
     */
    public static $redirectTo = 'index';

    /**
     * @var array
     */
    public static $relationships;

    /**
     * @var string
     */
    public static $controllerAction;

    /**
     * @var array
     */
    public static $softDeletes = false;

    /**
     * @var array
     */
    public static $search;

    /**
     * Show with tabs
     *
     * @var bool
     */
    public static $tabs;

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
    public function model(): object
    {
        $model = static::$model;
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
    public static function breadcrumbs(): array
    {
        //Default home value
        $home = [trans('belich::belich.navigation.home') => static::url()];

        //Set index
        if (static::action() === 'index') {
            return array_merge($home,
                [static::$pluralLabel => null]
            );
        }
        // For the rest of the action, if it is allowed
        if (in_array(static::action(), Belich::allowedActions())) {
            $action = str_replace('edit', 'update', static::action());
            return array_merge($home,
                [static::$label => Belich::resourceUrl()],
                [trans('belich::buttons.crud.' . $action) => null]
            );
        }
    }

    /**
     * Default actions
     *
     * @return array
     */
    public static function actions(): array
    {
        return [
            Utils::icon('eye') => Utils::route('show'),
            Utils::icon('edit') => Utils::route('edit'),
            Utils::icon('trash') => Utils::route('destroy'),
        ];
    }
}
