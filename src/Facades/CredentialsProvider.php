<?php

namespace Daguilarm\Belich\Facades;

use Illuminate\Support\ServiceProvider;

class CredentialsProvider extends ServiceProvider
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
        $this->app->singleton('Credentials',function()
        {
            return new \Daguilarm\Belich\Core\Credentials;
        });
    }
}
