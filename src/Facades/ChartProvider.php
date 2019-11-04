<?php

namespace Daguilarm\Belich\Facades;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

final class ChartProvider extends ServiceProvider
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
            return Helper::hasMetric($request);
        });

        /**
         * Create a Blade if directive for @ifMetrics
         * Check if a request has metrics
         *
         * @return string
         */
        Blade::if('hasMetricsLegends', static function ($request) {
            return Helper::hasMetricsLegends($request);
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
            return new \Daguilarm\Belich\Components\Metrics\Render();
        });
    }
}
