<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Core;

use Daguilarm\Belich\Core\Traits\Modelable;
use Daguilarm\Belich\Core\Traits\Resourceable;
use Daguilarm\Belich\Core\Traits\Routeable;
use Daguilarm\Belich\Core\Traits\Systemable;
use Illuminate\Http\Request;

abstract class Resources
{
    use Modelable,
        Resourceable,
        Routeable,
        Systemable;

    /**
     * @var Illuminate\Support\Collection
     */
    public static $fields;

    public static bool $accessToResource = true;
    public static string $actions = 'default';
    public static bool $displayInNavigation = true;
    public static bool $downloable = false;
    public static string $group;
    public static string $icon;
    public static string $imageCss = 'block h-10 rounded-full shadow-md';
    public static string $label;
    public static string $model;
    public static string $pluralLabel;
    public static string $redirectTo = 'index';
    public static array $relationships;
    public static string $controllerAction;
    public static bool $softDeletes = false;
    public static array $search = [];
    public static bool $tabs;

    /**
     * Default actions
     */
    public static function actions(): array
    {
        return [
            Utils::icon('eye') => Utils::route('show'),
            Utils::icon('edit') => Utils::route('edit'),
            Utils::icon('trash') => Utils::route('destroy'),
        ];
    }

    /**
     * Default breadcrumb
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
     * Set the custom metrics cards
     */
    public static function filters(Request $request): array
    {
        return [];
    }

    /**
     * Set the resource model
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
     * Get the fields displayed by the resource.
     */
    abstract public function fields(Request $request): array;

    /**
     * Set the custom cards
     */
    abstract public static function cards(Request $request): array;

    /**
     * Set the custom metrics cards
     */
    abstract public static function metrics(Request $request): array;
}
