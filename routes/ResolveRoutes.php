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
    ], function () : void {
        //Validation routes
        Route::post(Belich::pathName() . '/ajax/form/validation', namespace_path('App\Http\Controllers\ValidationController'))
            ->name('ajax.form.validation');

        //search routes
        Route::get(Belich::pathName() . '/ajax/search', namespace_path('App\Http\Controllers\SearchController'))
            ->name('ajax.search');

        //Generate routes from resources
        //The middleware can be setter from the config file
        $resources = getAllTheResourcesFromFolder()
            ->map(function($route) : void {
                //Get route ID
                $routeID = sprintf('{%s}', Str::singular($route));
                if($route) {
                    Route::resource(route_path($route), namespace_path('App\Http\Controllers\CrudController'));
                    Route::get(route_path($route) . '/' . $routeID . '/restore', namespace_path('App\Http\Controllers\CrudExtendedController@restore'))
                        ->name($route . '.restore');
                    Route::get(route_path($route) . '/' . $routeID . '/forceDelete', namespace_path('App\Http\Controllers\CrudExtendedController@forceDelete'))
                        ->name($route . '.forceDelete');
                    Route::post(route_path($route) . '/delete/selected', namespace_path('App\Http\Controllers\CrudExtendedController@deleteSelected'))
                        ->name($route . '.delete.selected');
                }
            });

        //Belich options
        Route::post(route_path('user/settings'), namespace_path('App\Http\Controllers\OptionController'))
            ->name('users.settings');

        //Belich export
        Route::post(route_path('exports/download'), namespace_path('App\Http\Controllers\DownloadController'))
            ->name('exports.download');

        //Load all the custom routes
        if (file_exists(app_path('/Belich/Routes.php'))) {
            require_once(app_path('/Belich/Routes.php'));
        }
});
