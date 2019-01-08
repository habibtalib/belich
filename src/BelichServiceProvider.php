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
        /**
        * Include the package classmap autoloader
        */
        if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
            include __DIR__ . '/../vendor/autoload.php';
        }

        /**
        * Load the helpers
        */
        foreach (glob(__DIR__ . '/app/Http/Helpers/*.php') as $file){
           require_once($file);
        }

        /**
        * Publish the belich directory and the dashboard constructor
        */
        $this->publishes([
            //Set the resources
            __DIR__ . '/../routes/Routes.php' => base_path('app/Belich/Routes.php'),
        ]);

        /**
        * Generate the dashboard routes
        */
        if (file_exists(__DIR__ . '/../routes/ResolveRoutes.php')) {
            require __DIR__ . '/../routes/ResolveRoutes.php';
        }

        /**
        * Load the views
        */
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'belich');

        /**
        * Publish the views
        */
        // $this->publishes([
        //     __DIR__ . '/resources/views' => base_path('resources/views/vendor/belich'),
        // ]);

        /**
        * Publish the assets
        */
        $this->publishes(
            [
                __DIR__ . '/../public/css/tailwind.min.css' => public_path('vendor/belich/css')
            ],
            'public'
        );

        /**
        * Publish the config file
        */
        $this->publishes([
            __DIR__ . '/../config/belich.php' => config_path('belich.php')
        ]);

        /**
        * Middleware
        */
        $this->app['router']->middleware('https', \Daguilarm\Belich\App\Http\Middleware\HttpsMiddleware::class);

        /**
         * Console comands
         */
        // if ($this->app->runningInConsole()) {
        //     $this->commands([
        //         \Daguilarm\Belich\App\Console\Commands\Hello::class,
        //     ]);
        // }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //Register default class
        $this->app->bind('BelichClass', function() {
            return $this->app->make(namespace_path('BelichClass'));
        });

        //Register the controller
        // $this->app->make(namespace_path('App\Http\Controllers\RestfullController'));
    }
}
