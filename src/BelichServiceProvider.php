<?php

namespace Daguilarm\Belich;

use Illuminate\Support\ServiceProvider;

class BelichServiceProvider extends ServiceProvider {
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        /*
        |--------------------------------------------------------------------------
        | Bootstrap
        |--------------------------------------------------------------------------
        */

        /**
        * Include the package classmap autoloader
        */
        if(file_exists(__DIR__ . '/../vendor/autoload.php')) {
            require_once(__DIR__ . '/../vendor/autoload.php');
        }

        /**
        * Load the helpers
        */
        foreach(glob(__DIR__ . '/app/Http/Helpers/*.php') as $file) {
            if($file) {
                require_once($file);
            }
        }

        /**
        * Generate the dashboard routes
        */
        if(file_exists(__DIR__ . '/../routes/ResolveRoutes.php')) {
            require_once(__DIR__ . '/../routes/ResolveRoutes.php');
        }

        /**
        * Load the views
        */
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'belich');

        /**
        * Middleware
        */
        $this->app['router']->middleware('https', \Daguilarm\Belich\App\Http\Middleware\HttpsMiddleware::class);

        /**
        * Configure a disk for the package
        */
        app()->config["filesystems.disks.belich"] = [
            'driver' => 'local',
            'root' => public_path('path'),
        ];

        /**
        * Generate the blade directives
        */
        if (file_exists(__DIR__ . '/../src/app/Providers/BladeProvider.php')) {
            require_once(__DIR__ . '/../src/app/Providers/BladeProvider.php');
        }

        /**
        * Load translations from...
        */
        $this->loadTranslationsFrom(resource_path('lang/vendor/belich'), 'belich');
        $this->loadJsonTranslationsFrom(resource_path('lang/vendor/belich'), 'belich');

        /**
         * Console comands
         */
        // if ($this->app->runningInConsole()) {
        //     $this->commands([
        //         \Daguilarm\Belich\App\Console\Commands\Hello::class,
        //     ]);
        // }

        /*
        |--------------------------------------------------------------------------
        | Publish...
        |--------------------------------------------------------------------------
        */

        /**
        * Publish the config file
        */
        $this->publishes([
            __DIR__ . '/../config/belich.php' => config_path('belich.php'),
            __DIR__ . '/../src/Stubs/validate-form.stub' => config_path('belich/stubs/validate-form.stub'),
        ]);

        /**
        * Publish the belich directory and the dashboard constructor
        */
        $this->publishes([
            //Set the resources
            __DIR__ . '/../routes/Routes.php' => base_path('app/Belich/Routes.php'),
        ]);

        /**
        * Publish the views
        */
        $this->publishes([
            __DIR__ . '/../resources/views/partials' => base_path('resources/views/vendor/belich/partials'),
        ]);

        /**
        * Publish the localization files
        */
        $this->publishes([
            __DIR__ . '/../resources/lang/en' => base_path('resources/lang/vendor/belich/en'),
        ]);

        /**
        * Publish the javascript
        */
        $this->publishes([
            __DIR__ . '/../resources/js/custom.js' => public_path('public/js/vendor/belich')
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //Register default class
        // $this->app->bind('BelichClass', function() {
        //     return $this->app->make(namespace_path('BelichClass'));
        // });

        //Register the controller
        // $this->app->make(namespace_path('App\Http\Controllers\RestfullController'));
    }
}
