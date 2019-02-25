<?php

namespace Daguilarm\Belich\Facades;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class ChartProvider extends ServiceProvider
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
        Blade::if('hasMetrics', function ($request) {
            return hasMetric($request);
        });

        /**
         * Create a Blade if directive for @ifMetrics
         * Check if a request has metrics
         *
         * @return string
         */
        Blade::if('hasMetricsLegends', function ($request) {
            return hasMetricsLegends($request);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Chart',function()
        {
            return new \Daguilarm\Belich\Components\Metrics\Render;
        });
    }
}
