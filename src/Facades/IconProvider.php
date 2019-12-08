<?php

namespace Daguilarm\Belich\Facades;

use Illuminate\Support\ServiceProvider;

final class IconProvider extends ServiceProvider
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
        $this->app->singleton('Icon', static function () {
            return new \Daguilarm\Belich\Components\Icon();
        });
    }
}
