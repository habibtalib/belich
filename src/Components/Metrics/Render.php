<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Components\Metrics;

use Daguilarm\Belich\Components\Metrics\Traits\Javascriptable;
use Daguilarm\Belich\Components\Metrics\Traits\Stylable;
use Daguilarm\Belich\Components\Metrics\Traits\Templatable;
use Illuminate\Http\Request;

final class Render
{
    use Javascriptable,
        Templatable,
        Stylable;

    private string $javascript = '//cdn.jsdelivr.net/chartist.js/latest/chartist.min.js';
    private string $css = '//cdn.jsdelivr.net/chartist.js/latest/chartist.min.css';

    /**
     * Render the metric card
     */
    public function render(Request $request): string
    {
        //Render the metric view
        $metrics = collect($request->metrics)
            ->map(static function ($metric) {
                return view('belich::components.metrics.chart', compact('metric'))->render();
            });

        return $metrics->implode('');
    }

    /**
     * Create the assets
     */
    public function assets(string $type = 'js'): string
    {
        $cssTemplate = '<link rel="stylesheet" href="%s">';
        $jsTemplate = '<script src="%s"></script>';

        return $type === 'javascript' || $type === 'script' || $type === 'js'
            ? sprintf($jsTemplate, $this->javascript)
            : sprintf($cssTemplate, $this->css);
    }

    /**
     * Create the metric
     */
    public function get(): string
    {
        //Set javascript key
        $key = md5($this->uriKey);

        //Set var object
        $varObject = sprintf('var data_%s={labels:[%s], series:%s};', $key, $this->formatLabels($this->labels), $this->formatSeries($this->series));

        //Set the chartist object
        $varChartist = $this->graphSelector($this->type, $key);

        return sprintf('%s%s', $varObject, $varChartist);
    }

    /*
    |--------------------------------------------------------------------------
    | Graphs selector
    |--------------------------------------------------------------------------
    */

    /**
     * Graph type selector
     */
    private function graphSelector(string $type, string $key): string
    {
        $filter = [
            'bars' => 'barGraph',
            'horizontal-bars' => 'horizontalBarGraph',
            'pie' => 'pieGraph',
            'line' => 'lineGraph',
        ];

        if (in_array($type, array_keys($filter))) {
            $selector = $filter[$type];

            return $this->{$selector}($key);
        }

        throw new \InvalidArgumentException('Invalid Chart type. Please, select a valid one.');
    }

    /*
    |--------------------------------------------------------------------------
    | Graphs types
    |--------------------------------------------------------------------------
    */

    /**
     * Create a Line Graph
     */
    private function lineGraph(string $key): string
    {
        $withArea = $this->withArea ? static::templateLineGraphOptions() : '';

        return sprintf(
            static::templateLineGraph(),
            $this->uriKey,
            $key,
            $withArea
        );
    }

    /**
     * Create a Bar Graph
     */
    private function barGraph(string $key): string
    {
        return sprintf(
            static::templateBarGraph(),
            $this->uriKey,
            $key,
            static::templateBarGraphOptions()
        );
    }

    /**
     * Create a Horizontal Bar Graph
     */
    private function horizontalBarGraph(string $key): string
    {
        return sprintf(
            static::templateBarGraph(),
            $this->uriKey,
            $key,
            static::templateHorizontalBarGraphOptions()
        );
    }

    /**
     * Create a Pie Graph
     */
    private function pieGraph(string $key): string
    {
        return sprintf(
            static::templatePieGraph(),
            $this->uriKey,
            $key,
            static::templatePieGraphOptions($key)
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    /**
     * Format the labels to render
     *
     * @param  mixed  $values
     */
    private function formatLabels($values): string
    {
        //To collection
        $values = is_array($values) ? collect($values) : $values;

        //Serialize the values
        return $values
            ->map(static function ($value) {
                return sprintf("'%s'", $value);
            })->implode(',');
    }

    /**
     * Format the series to render
     *
     * @param  mixed  $values
     */
    private function formatSeries($series): string
    {
        //To collection
        $collection = is_array($series) ? collect($series) : $series;

        //Serialize the values
        return sprintf('[%s]',
            $collection->map(function ($value) {
                //Multilevel loop for arrays
                if (is_array($value)) {
                    return $this->formatSeries($value);
                }
                //Regular value
                return sprintf("'%s'", $value);
            })
                //To string
                ->implode(',')
        );
    }
}
