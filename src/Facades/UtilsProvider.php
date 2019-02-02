<?php

namespace Daguilarm\Belich\Facades;

use Illuminate\Support\ServiceProvider;

class UtilsProvider extends ServiceProvider
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
        $this->app->singleton('Utils',function()
        {
            return new \Daguilarm\Belich\Core\Utils;
        });
    }
}
