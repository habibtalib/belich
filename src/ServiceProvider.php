<?php

namespace Daguilarm\Belich;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider as Provider;
use Spatie\BladeX\Facades\BladeX;

final class ServiceProvider extends Provider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->registerPublishing();
        }

        $this->registerBootstrap();
        $this->registerRoutes();
        $this->registerResources();
        $this->registerConsole();
        $this->registerMigrations();

        //Blade X components
        BladeX::component('belich::components.*');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        //Belich Facade
        $this->app->register(\Daguilarm\Belich\Facades\BelichProvider::class);
        AliasLoader::getInstance()->alias('Belich', \Daguilarm\Belich\Facades\Belich::class);

        //Chart Facade
        $this->app->register(\Daguilarm\Belich\Facades\ChartProvider::class);
        AliasLoader::getInstance()->alias('Chart', \Daguilarm\Belich\Facades\Chart::class);
    }

    /**
     * Register the package bootstrap
     *
     * @return void
     */
    protected function registerBootstrap(): void
    {
        //Include the package classmap autoloader
        if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
            require_once(__DIR__ . '/../vendor/autoload.php');
        }

        // Middleware
        $this->app['router']->pushMiddlewareToGroup('https', \Daguilarm\Belich\App\Http\Middleware\HttpsMiddleware::class);
        $this->app['router']->pushMiddlewareToGroup('belich', \Daguilarm\Belich\App\Http\Middleware\BelichMiddleware::class);
        $this->app['router']->pushMiddlewareToGroup('minify', \Daguilarm\Belich\App\Http\Middleware\MinifyMiddleware::class);

        // Load the helper functions
        foreach (glob(__DIR__ . '/app/Http/Helpers/*.php') as $file) {
            require_once($file);
        }
    }

    /**
     * Register the package routes
     *
     * @return void
     */
    protected function registerRoutes(): void
    {
        //Auth routes
        if (file_exists(__DIR__ . '/../routes/AuthRoutes.php')) {
            require_once(__DIR__ . '/../routes/AuthRoutes.php');
        }

        //Dashboard routes
        if (file_exists(__DIR__ . '/../routes/ResolveRoutes.php')) {
            require_once(__DIR__ . '/../routes/ResolveRoutes.php');
        }
    }

    /**
     * Register the package resources
     *
     * @return void
     */
    protected function registerResources(): void
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
    protected function registerPublishing(): void
    {
        //Publish the config file
        $this->publishes([
            __DIR__ . '/../config/belich.php' => config_path('belich.php'),
            __DIR__ . '/../src/stubs/validate-form.stub' => config_path('belich/stubs/validate-form.stub'),
        ]);

        //Publish the views
        $this->publishes([
            __DIR__ . '/../resources/views/actions' => base_path('resources/views/vendor/belich/actions'),
            __DIR__ . '/../resources/views/auth' => base_path('resources/views/vendor/belich/auth'),
            __DIR__ . '/../resources/views/cards' => base_path('resources/views/vendor/belich/cards'),
            __DIR__ . '/../resources/views/pages' => base_path('resources/views/vendor/belich/pages'),
            __DIR__ . '/../resources/views/partials' => base_path('resources/views/vendor/belich/partials'),
            __DIR__ . '/../resources/views/components' => base_path('resources/views/vendor/belich/components'),
            __DIR__ . '/../resources/views/dashboard' => base_path('resources/views/vendor/belich/dashboard'),
        ]);

        //Publish the localization files
        $this->publishes([
            __DIR__ . '/../resources/lang' => base_path('resources/lang/vendor/belich'),
        ]);

        //Publish the public folder
        $this->publishes([
            __DIR__ . '/../public/' => public_path('vendor/belich')
        ]);

        //Publish the belich directory and the dashboard constructor
        $this->publishes([
            //Set the resources
            __DIR__ . '/stubs/routes.stub' => base_path('app/Belich/Routes.php'),
        ]);

        //Publish the belich default resource: User
        $this->publishes([
            //Set the resources
            __DIR__ . '/stubs/defaults/user_resource.stub' => base_path('app/Belich/Resources/User.php'),
            __DIR__ . '/stubs/defaults/profile_resource.stub' => base_path('app/Belich/Resources/Profile.php'),
        ]);

        //Publish the belich default policy: User
        $this->publishes([
            //Set the resources
            __DIR__ . '/stubs/defaults/user_policy.stub' => base_path('app/Policies/UserPolicy.php'),
        ]);
    }

    /**
     * Register the package console commands
     *
     * @return void
     */
    protected function registerConsole(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Daguilarm\Belich\App\Console\Commands\CardCommand::class,
                \Daguilarm\Belich\App\Console\Commands\MetricCommand::class,
                \Daguilarm\Belich\App\Console\Commands\ResourceCommand::class,
                \Daguilarm\Belich\App\Console\Commands\ResourceCommand::class,
            ]);
        }
    }

    /**
     * Register the package migrations
     *
     * @return void
     */
    protected function registerMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }
}
