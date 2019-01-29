<?php

namespace Daguilarm\Belich;

use Illuminate\Support\ServiceProvider;

class BelichFacadeProvider extends ServiceProvider
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
            return new \Daguilarm\Belich\Core\Builder;
        });
    }
}
