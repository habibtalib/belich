<?php

use Daguilarm\Belich\Facades\Helper;
use Illuminate\Support\Str;

//Load the auth routes
if (file_exists(__DIR__ . '/../routes/AuthRoutes.php')) {
    require_once __DIR__ . '/../routes/AuthRoutes.php';
}

/** Belich Routes */
Route::group([
    'as' => Belich::pathName() . '.',
    'middleware' => Belich::middleware(),
], static function (): void {
    //Dashboard/Home route
    Route::get(Belich::path(), '\App\Belich\Dashboard');

    //Validation routes
    Route::post(Belich::pathName() . '/ajax/form/validation', Helper::namespace_path('App\Http\Controllers\ValidationController'))
        ->name('ajax.form.validation');

    //search routes
    Route::get(Belich::pathName() . '/ajax/search', Helper::namespace_path('App\Http\Controllers\SearchController'))
        ->name('ajax.search');

    //Generate routes from resources
    //The middleware can be setter from the config file
    Helper::getAllTheResourcesFromFolder()
        ->map(static function ($route): void {
            //Get route ID
            $routeID = sprintf('{%s}', Str::singular($route));
            if ($route) {
                Route::resource(Helper::route_path($route), Helper::namespace_path('App\Http\Controllers\CrudController'));
                Route::get(Helper::route_path($route) . '/' . $routeID . '/restore', Helper::namespace_path('App\Http\Controllers\CrudExtendedController@restore'))
                    ->name($route . '.restore');
                Route::get(Helper::route_path($route) . '/' . $routeID . '/forceDelete', Helper::namespace_path('App\Http\Controllers\CrudExtendedController@forceDelete'))
                    ->name($route . '.forceDelete');
                Route::post(Helper::route_path($route) . '/delete/selected', Helper::namespace_path('App\Http\Controllers\CrudExtendedController@deleteSelected'))
                    ->name($route . '.delete.selected');
            }
        });

    //Belich options
    Route::post(Helper::route_path('user/settings'), Helper::namespace_path('App\Http\Controllers\OptionController'))
        ->name('users.settings');

    //Belich export
    Route::post(Helper::route_path('exports/download'), Helper::namespace_path('App\Http\Controllers\DownloadController'))
        ->name('exports.download');

    //Load all the custom routes
    if (file_exists(app_path('/Belich/Routes.php'))) {
        require_once app_path('/Belich/Routes.php');
    }
});
