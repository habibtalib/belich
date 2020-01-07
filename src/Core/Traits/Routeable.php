<?php

namespace Daguilarm\Belich\Core\Traits;

use Daguilarm\Belich\Core\Search\Search;
use Illuminate\Support\Facades\Request;

trait Routeable
{
    /**
     * Get Controller action ['index', 'edit', 'create' or 'show'] from the route
     *
     * @return string
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
     *
     * @return array
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
     *
     * @param string $controllerAction
     * @param int|object $data
     *
     * @return string
     */
    public static function actionRoute(string $controllerAction, $data = null): string
    {
        $route = sprintf('%s.%s.%s', static::pathName(), static::resource(), $controllerAction);

        if (is_object($data) && optional($data)->id > 0) {
            return route($route, $data->id);
        }

        return is_numeric($data)
            // Numeric value
            ? route($route, $data)
            // Default value
            : route($route);
    }
}
