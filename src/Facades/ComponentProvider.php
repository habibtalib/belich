<?php

namespace Daguilarm\Belich\Facades;

use Illuminate\Support\ServiceProvider;

class ComponentProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Component',function()
        {
            return new \Daguilarm\Belich\Core\Component;
        });
    }
}
