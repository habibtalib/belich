<?php

/** Belich Routes */
Route::group([
        'as' => Utils::basePath(). '.',
    ], function () {

        //Define middleware
        $middleware = config('belich.middleware') ?? ['web', 'auth', 'https'];

        //Validation routes
        Route::post(Utils::basePath(). '/ajax/form/validation', namespace_path('App\Http\Controllers\ValidationController'))
            ->middleware($middleware)
            ->name('ajax.form.validation');

        //Load all the custom routes
        if (file_exists(app_path('/Belich/Routes.php'))) {
            require_once(app_path('/Belich/Routes.php'));
        }

        //Generate routes from resources
        //The middleware can be setter from the config file
        return getAllTheResourcesFromFolder()
            ->map(function($route) use ($middleware) {
                return Route::resource(route_path($route), namespace_path('App\Http\Controllers\RestfullController'))
                        ->middleware($middleware);
            });
});
