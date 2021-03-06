<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Components\Helpers;

use Daguilarm\Belich\Components\Metrics\Graph;

trait Metrics
{
    /**
     * Determine if the view has a metric chart
     * Helper for the blade Metrics. Components\metrics\legend.blade.php
     */
    public function hasMetrics($request): bool
    {
        return optional($request)->metrics
            ? count($request->metrics) > 0
            : false;
    }

    /**
     * Determine if the view has a metric legend
     */
    public function hasMetricsLegends(object $request): bool
    {
        return ($request->legend_h || $request->legend_v) && $request->type !== 'pie'
            ? true
            : false;
    }

    /**
     * Set the color between the options, for the metrics in blade template
     * Helper for the blade Metrics. Components\metrics\chart.blade.php and Components/metrics/legend.blade.php
     */
    public function metricsColor(Graph $metric, string $type): string
    {
        return $metric->defineColor[$type] ?? $metric->color;
    }
}
