<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Core\Traits;

use Daguilarm\Belich\Core\Search\Search;
use Illuminate\Support\Facades\Request;

trait Routeable
{
    /**
     * Get Controller action ['index', 'edit', 'create' or 'show'] from the route
     */
    public static function action(): string
    {
        //Cannot pass directly as reference!!
        $route = static::route();

        return app(Search::class)->searchRequest()
            //Search action (is in index...)
            ? 'index'
            //Return last item from the array
            : end($route);
    }

    /**
     * Get route divided in arrays
     * will return an array like: ['dashboard', 'users', 'index']
     */
    public static function route(): array
    {
        return is_null(Request::route())
            //Hack for artisan route:list
            //I don't know why... WTF!
            ? ['dashboard', 'users', 'index']
            //Get route name
            : explode('.', Request::route()->getName());
    }

    /**
     * Get the button action route
     */
    public static function actionRoute(string $controllerAction, $data = null): string
    {
        $route = sprintf('%s.%s.%s', static::pathName(), static::resource(), $controllerAction);

        return self::actionRouteGenerator($data, $route);
    }

    /**
     * Generate the action route
     *
     * @param object|int $data
     */
    private static function actionRouteGenerator($data, string $route)
    {
        // Object data
        if (is_object($data) && optional($data)->id > 0) {
            return route($route, $data->id);
        }

        // Numeric data
        if (is_numeric($data)) {
            return route($route, $data);
        }

        return route($route);
    }
}
