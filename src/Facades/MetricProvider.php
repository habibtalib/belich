<?php

namespace Daguilarm\Belich\Facades;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class MetricProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Create a Blade if directive for @ifMetrics
         * Check if a request has metrics
         *
         * @return string
         */
        Blade::if('ifMetrics', function ($request) {
            if(!empty($request->metrics)) {
                return count($request->metrics) > 0;
            }

            return false;
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Metric',function()
        {
            return new \Daguilarm\Belich\Components\Metrics\Render;
        });
    }
}
