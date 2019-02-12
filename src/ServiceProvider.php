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
        if ($this->app->runningInConsole()) {
            $this->registerPublishing();
        }

        $this->registerBootstrap();
        $this->registerRoutes();
        $this->registerResources();
        $this->registerConsole();
        $this->registerMigrations();
    }

    /**
     * Register the package bootstrap
     *
     * @return void
     */
    protected function registerBootstrap()
    {
        //Include the package classmap autoloader
        if(file_exists(__DIR__ . '/../vendor/autoload.php')) {
            require_once(__DIR__ . '/../vendor/autoload.php');
        }

        // Middleware
        $this->app['router']->pushMiddlewareToGroup('https', \Daguilarm\Belich\App\Http\Middleware\HttpsMiddleware::class);

        // Load the helper functions
        foreach (glob(__DIR__ . '/app/Http/Helpers/*.php') as $file) {
            require_once($file);
        }

        //Configure a disk for the package
        app()->config["filesystems.disks.belich"] = [
            'driver' => 'local',
            'root' => public_path('path'),
        ];
    }

    /**
     * Register the package routes
     *
     * @return void
     */
    protected function registerRoutes()
    {
        //Auth routes
        if(file_exists(__DIR__ . '/../routes/AuthRoutes.php')) {
            require_once(__DIR__ . '/../routes/AuthRoutes.php');
        }

        //Dashboard routes
        if(file_exists(__DIR__ . '/../routes/ResolveRoutes.php')) {
            require_once(__DIR__ . '/../routes/ResolveRoutes.php');
        }
    }

    /**
     * Register the package resources
     *
     * @return void
     */
    protected function registerResources()
    {
        //Load the views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'belich');

        //Load the blade service provider
        require_once(__DIR__ . '/../src/app/Providers/BladeProvider.php');

        //Load language translations...
        $this->loadTranslationsFrom(resource_path('lang/vendor/belich'), 'belich');
        $this->loadJsonTranslationsFrom(resource_path('lang/vendor/belich'), 'belich');
    }

    /**
     * Register the package's publishable resources.
     *
     * @return void
     */
    protected function registerPublishing()
    {
        //Publish the config file
        $this->publishes([
            __DIR__ . '/../config/belich.php' => config_path('belich.php'),
            __DIR__ . '/../src/Stubs/validate-form.stub' => config_path('belich/stubs/validate-form.stub'),
        ]);

        //Publish the belich directory and the dashboard constructor
        $this->publishes([
            //Set the resources
            __DIR__ . '/../routes/Routes.php' => base_path('app/Belich/Routes.php'),
        ]);

        //Publish the views
        $this->publishes([
            __DIR__ . '/../resources/views/actions' => base_path('resources/views/vendor/belich/actions'),
            __DIR__ . '/../resources/views/auth' => base_path('resources/views/vendor/belich/auth'),
            __DIR__ . '/../resources/views/pages' => base_path('resources/views/vendor/belich/pages'),
            __DIR__ . '/../resources/views/partials' => base_path('resources/views/vendor/belich/partials'),
        ]);

        //Publish the localization files
        $this->publishes([
            __DIR__ . '/../resources/lang' => base_path('resources/lang/vendor/belich'),
        ]);

        //Publish the public folder
        $this->publishes([
            __DIR__ . '/../public/' => public_path('vendor/belich')
        ]);
    }

    /**
     * Register the package console commands
     *
     * @return void
     */
    protected function registerConsole()
    {
        // if ($this->app->runningInConsole()) {
        //     $this->commands([
        //         \Daguilarm\Belich\App\Console\Commands\Hello::class,
        //     ]);
        // }
    }

    /**
     * Register the package migrations
     *
     * @return void
     */
    protected function registerMigrations()
    {
        //$this->loadMigrationsFrom(__DIR__.'/../database/migrations');
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
    }
}
