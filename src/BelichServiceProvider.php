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
        if (\File::exists(__DIR__.'/../vendor/autoload.php')) {
            include __DIR__.'/../vendor/autoload.php';
        }

        /**
        * Publish the belich directory and the dashboard constructor
        */
        $this->publishes([
            //Set the resources
            __DIR__.'/../routes/Routes.php' => base_path('app/Belich/Routes.php'),
        ]);

        /**
        * Generate the dashboard routes
        */
        require __DIR__.'/../routes/ResolveRoutes.php';

        /**
        * Load the helpers
        */
        if (file_exists(__DIR__.'/app/Http/helpers.php')) {
            require_once __DIR__.'/app/Http/helpers.php';
        }

        /**
        * Load the views
        */
        $this->loadViewsFrom(__DIR__.'/resources/views', 'belich');

        /**
        * Publish the views
        */
        // $this->publishes([
        //     __DIR__.'/resources/views' => base_path('resources/views/vendor/belich'),
        // ]);

        /**
        * Publish the assets
        */
        // $this->publishes(
        //     [__DIR__.'/public' => public_path('vendor/belich')],
        //     'public'
        // );

        /**
        * Publish the config file
        */
        $this->publishes([
            __DIR__.'/../config/belich.php' => config_path('belich.php')
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
            return $this->app->make('Daguilarm\Belich\BelichClass');
        });

        //Register the controller
        $this->app->make('Daguilarm\Belich\App\Http\Controllers\RestfullController');
    }
}
