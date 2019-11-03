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
    public function boot(): void
    {
        /**
         * Create a Blade if directive for @ifMetrics
         * Check if a request has metrics
         *
         * @return string
         */
        Blade::if('hasMetrics', static function ($request) {
            return hasMetric($request);
        });

        /**
         * Create a Blade if directive for @ifMetrics
         * Check if a request has metrics
         *
         * @return string
         */
        Blade::if('hasMetricsLegends', static function ($request) {
            return hasMetricsLegends($request);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton('Chart', static function () {
            return new \Daguilarm\Belich\Components\Metrics\Render;
        });
    }
}
