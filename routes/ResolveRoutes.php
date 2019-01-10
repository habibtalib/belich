<?php

/** Belich Routes */
Route::group([
        'as' => getRouteBasePath() . '.',
    ], function () {

        //Load all the custom routes
        if (file_exists(app_path('/Belich/Routes.php'))) {
            require_once(app_path('/Belich/Routes.php'));
        }

        //Generate routes from resources
        //The middleware can be setter from the config file
        return getAllTheResourcesFromFolder()->map(function($route) {
            $middleware = config('belich.middleware') ?? ['web', 'auth', 'https'];
            return Route::resource(route_path($route), namespace_path('App\Http\Controllers\RestfullController'))
                    ->middleware($middleware);
        });
});
