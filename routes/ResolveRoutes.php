<?php

use Illuminate\Support\Str;

//Load the auth routes
if (file_exists(__DIR__ . '/../routes/AuthRoutes.php')) {
    require_once(__DIR__ . '/../routes/AuthRoutes.php');
}

/** Belich Routes */
Route::group([
        'as' => Belich::pathName() . '.',
        'middleware' => Belich::middleware(),
    ], function () {

        //Validation routes
        Route::post(Belich::pathName() . '/ajax/form/validation', namespace_path('App\Http\Controllers\ValidationController'))
            ->name('ajax.form.validation');

        //Generate routes from resources
        //The middleware can be setter from the config file
        $resources = getAllTheResourcesFromFolder()
            ->map(function($route) {
                //Get route ID
                $routeID = sprintf('{%s}', Str::singular($route));
                if($route) {
                    Route::resource(route_path($route), namespace_path('App\Http\Controllers\RestfullController'));
                    Route::get(route_path($route) . '/' . $routeID . '/restore', namespace_path('App\Http\Controllers\RestfullController@restore'))
                        ->name($route . '.restore');
                    Route::get(route_path($route) . '/' . $routeID . '/forceDelete', namespace_path('App\Http\Controllers\RestfullController@forceDelete'))
                        ->name($route . '.forceDelete');
                }
            });

        //Belich options
        Route::post(route_path('/user/settings'), namespace_path('App\Http\Controllers\OptionsController'))
            ->name('users.settings');

        //Load all the custom routes
        if (file_exists(app_path('/Belich/Routes.php'))) {
            require_once(app_path('/Belich/Routes.php'));
        }
});
