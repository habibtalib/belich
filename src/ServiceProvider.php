<?php

namespace Daguilarm\Belich;

use Illuminate\Support\ServiceProvider as Provider;
use Illuminate\Foundation\AliasLoader;

class ServiceProvider extends Provider {
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
       if(file_exists(__DIR__ . '/app/Http/helpers.php')) {
           require_once(__DIR__ . '/app/Http/helpers.php');
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
        * Load the service providers
        */
        require_once(__DIR__ . '/../src/app/Providers/BladeProvider.php');

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
            __DIR__ . '/../resources/lang' => base_path('resources/lang/vendor/belich'),
        ]);

        /**
        * Publish the public
        */
        $this->publishes([
            __DIR__ . '/../public/' => public_path('vendor/belich')
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //Belich Facade
        $this->app->register(\Daguilarm\Belich\Facades\BelichProvider::class);
        AliasLoader::getInstance()->alias('Belich', \Daguilarm\Belich\Facades\Belich::class);

        //Utils Facade
        $this->app->register(\Daguilarm\Belich\Facades\UtilsProvider::class);
        AliasLoader::getInstance()->alias('Utils', \Daguilarm\Belich\Facades\Utils::class);
    }
}
