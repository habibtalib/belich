<?php

namespace Daguilarm\Belich\Facades;

use Illuminate\Support\ServiceProvider;

class HelperProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        //Nothing
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton('Helper', static function () {
            return new \Daguilarm\Belich\Components\Helper();
        });
    }
}
