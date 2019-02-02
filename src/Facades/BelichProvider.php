<?php

namespace Daguilarm\Belich\Facades;

use Illuminate\Support\ServiceProvider;

class BelichProvider extends ServiceProvider
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
        $this->app->singleton('Belich',function()
        {
            return new \Daguilarm\Belich\Core\Belich;
        });
    }
}
