<?php

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
            ->middleware(Belich::middleware())
            ->name('ajax.form.validation');

        //Generate routes from resources
        //The middleware can be setter from the config file
        $resources = getAllTheResourcesFromFolder()
            ->map(function($route) {
                if($route) {
                    return Route::resource(route_path($route), namespace_path('App\Http\Controllers\RestfullController'))
                            ->middleware(Belich::middleware());
                }
            });

        //Load all the custom routes
        if (file_exists(app_path('/Belich/Routes.php'))) {
            require_once(app_path('/Belich/Routes.php'));
        }
});
