<?php

namespace Daguilarm\Belich\Components\Metrics;

use Daguilarm\Belich\Components\Metrics\Templates;
use Daguilarm\Belich\Components\Metrics\Traits\Javascriptable;
use Daguilarm\Belich\Components\Metrics\Traits\Stylable;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class Render {

    use Javascriptable, Templates, Stylable;

    /** @var string */
    private $js  = '//cdn.jsdelivr.net/chartist.js/latest/chartist.min.js';

    /** @var string */
    private $css = '//cdn.jsdelivr.net/chartist.js/latest/chartist.min.css';

    /**
     * Render the metric card
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function render(Request $request) : string
    {
        //Render the metric view
        $metrics = collect($request->metrics)
            ->map(function($metric) {
                return view('belich::components.metrics.chart', compact('metric'))->render();
            });

        return $this->hasResults($metrics);
    }

    /**
     * Create the assets
     *
     * @param  string  $type
     * @return string
     */
    public function assets(string $type = 'js') : string
    {
        $cssTemplate = '<link rel="stylesheet" href="%s">';
        $jsTemplate  = '<script src="%s"></script>';

        return ($type === 'javascript' || $type === 'script' || $type === 'js')
            ? sprintf($jsTemplate, $this->js)
            : sprintf($cssTemplate, $this->css);
    }

    /**
     * Create the metric
     *
     * @return string
     */
    public function get()
    {
        //Set javascript key
        $key = md5($this->uriKey);

        //Set var object
        $varObject = sprintf("var data_%s={labels:[%s], series:%s};", $key, $this->formatLabels($this->labels), $this->formatSeries($this->series));

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
    *
    * @param string $type
    * @param string $key
    * @return string
    */
    private function graphSelector(string $type, string $key)
    {
        if($type === 'bars') {
            return $this->barGraph($key);
        }

        if($type === 'horizontal-bars') {
            return $this->horizontalBarGraph($key);
        }

        if($type === 'pie') {
            return $this->pieGraph($key);
        }

        if($type === 'line') {
            return $this->lineGraph($key);
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
     *
     * @param string $key
     * @return string
     */
    private function lineGraph(string $key) : string
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
     *
     * @param string $key
     * @return string
     */
    private function barGraph(string $key)  : string
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
     *
     * @param string $key
     * @return string
     */
    private function horizontalBarGraph(string $key)  : string
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
     *
     * @param string $key
     * @return string
     */
    private function pieGraph(string $key)
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
     * Check for results
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    private function hasResults(Collection $metrics) : string
    {
        //If results...
        $results = ($metrics->count() > 0)
            ? $metrics->implode('')
            : null;

        return $results
            ? sprintf('<div class="flex mb-12">%s</div>', $results)
            : '';
    }

    /**
     * Format the labels to render
     *
     * @param  array|Collection  $values
     * @return string
     */
    private function formatLabels($values) : string
    {
        //To collection
        $values = is_array($values) ? collect($values) : $values;

        //Serialize the values
        return $values
            ->map(function($value) {
                return sprintf("'%s'", $value);
            })->implode(',');
    }

    /**
     * Format the series to render
     *
     * @param  array|Collection  $values
     * @return string
     */
    private function formatSeries($series) : string
    {
        //To collection
        $collection = is_array($series) ? collect($series) : $series;

        //Serialize the values
        return sprintf('[%s]', $collection->map(function($value) {
                //Multilevel loop for arrays
                if(is_array($value)) {
                    return $this->formatSeries($value);
                }
                //Regular value
                return sprintf("'%s'", $value);
            //To string
            })->implode(',')
        );
    }
}
