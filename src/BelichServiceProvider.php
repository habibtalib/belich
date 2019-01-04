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
        * Generate the dashboard routes
        */
        $this->app->router->group(['namespace' => 'Daguilarm\Belich\App\Http\Controllers'],
            function() {
                require __DIR__.'/routes/dashboard.php';
            }
        );

        /**
        * Load the helpers
        */
        if (file_exists(__DIR__.'/helpers.php')) {
            require_once __DIR__.'/helpers.php';
        }

        /**
        * Load the views
        */
        $this->loadViewsFrom(__DIR__.'/resources/views', 'belich');
        /**
        * Publish the views
        */
        $this->publishes([
            __DIR__.'/resources/views' => base_path('resources/views/vendor/belich'),
        ]);

        /**
        * Publish the assets
        */
        $this->publishes(
            [__DIR__.'/public' => public_path('vendor/belich')],
            'public'
        );

        /**
        * Publish the config file
        */
        $this->publishes([__DIR__.'/config' => config_path('vendor/belich')]);

        /**
        * Middleware
        */
        // $kernel = $this->app['Illuminate\Contracts\Http\Kernel'];
        // $kernel->pushMiddleware('Daguilarm\Laragoes\App\Http\Middleware\BelichMiddleware');

        /**
        * Migrations
        */
        //$this->loadMigrationsFrom(__DIR__.'/database/migrations');

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
        $this->app->bind('BelichClass', function() {
            return $this->app->make('Daguilarm\Belich\BelichClass');
        });
    }
}
