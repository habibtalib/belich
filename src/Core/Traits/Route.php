<?php

namespace Daguilarm\Belich\Core\Traits;

use Illuminate\Support\Facades\Request;

trait Route {

    /*
    |--------------------------------------------------------------------------
    | Public Static Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Get Controller action ['index', 'edit', 'create' or 'show'] from the route
     *
     * @return string
     */
    public static function action() : string
    {
        //Cannot pass directly as reference!!
        $route = static::route();

        //Return last item from the array
        return end($route);
    }

    /**
     * Get route divided in arrays
     * will return an array like: ['dashboard', 'users', 'index']
     *
     * @return array
     */
    public static function route() : array
    {
        //Hack for artisan route:list
        //I don't know why... WTF!
        if(is_null(Request::route())){
            return ['dashboard', 'users', 'index'];
        }

        //Get route name
        return explode('.', Request::route()->getName());
    }

    /**
     * Get the button action route
     *
     * @param string $controllerAction
     * @param object $data
     * @return string
     */
    public static function actionRoute(string $controllerAction, $data = null) : string
    {
        $route = sprintf('%s.%s.%s', static::pathName(), static::resource(), $controllerAction);

        return !empty($data->id)
            ? route($route, $data->id)
            : route($route);
    }
}
