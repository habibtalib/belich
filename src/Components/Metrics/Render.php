<?php

namespace Daguilarm\Belich\Components\Metrics;

use Daguilarm\Belich\Components\Metrics\Traits\Javascriptable;
use Daguilarm\Belich\Components\Metrics\Traits\Stylable;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class Render {

    use Javascriptable, Stylable;

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
                return view('belich::components.metrics', compact('metric'))->render();
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
        $varObject = sprintf("var data_%s={labels:[%s],series:%s};", $key, $this->formatLabels($this->labels), $this->formatSeries($this->series));

        //Set the chartist object
        $varChartist = $this->graphSelector($this->type, $key);

        return sprintf('<script>%s%s</script>', $varObject, $varChartist);
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

        return $this->lineGraph($key);
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
        $withArea = $this->withArea ? static::templateShowArea() : '';

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
    | Javascript templates for Graphs
    |--------------------------------------------------------------------------
    */

    /**
     * Template Line Graph
     *
     * @return string
     */
    private static function templateLineGraph() : string
    {
        return "new Chartist.Line('.%s',data_%s,%s);";
    }

    /**
     * Template Bar Graph options
     *
     * @return string
     */
    private static function templateBarGraph() : string
    {
        return "new Chartist.Bar('.%s',data_%s,%s);";
    }

    /**
     * Template Pie Graph
     *
     * @return string
     */
    private static function templatePieGraph() : string
    {
        return "var sum=function(a,b){return a+b};new Chartist.Pie('.%s',data_%s,%s);";
    }

    /*
    |--------------------------------------------------------------------------
    | Javascript templates for options
    |--------------------------------------------------------------------------
    */

    /**
     * Template show area
     *
     * @return string
     */
    private static function templateShowArea() : string
    {
        return
            '{' .
                'showArea:true,low:0'.
            '}';
    }

    /**
     * Template Bar Graph options
     *
     * @return string
     */
    private static function templateBarGraphOptions() : string
    {
        return  "{" .
                    "seriesBarDistance:10," .
                    "axisX:{" .
                        "offset:30" .
                    "}," .
                    "axisY:{" .
                        "offset:40," .
                        "labelInterpolationFnc:function(value)" .
                        "{" .
                            "return value" .
                        "}," .
                        "scaleMinSpace:15" .
                    "}" .
                "}";
    }

    /**
     * Template Horizontal Bar Graph options
     *
     * @return string
     */
    private function templateHorizontalBarGraphOptions() : string
    {
        return  "reverseData:true," .
                "horizontalBars:true," .
                "seriesBarDistance:10," .
                "axisX:" .
                "{" .
                    "offset: 30" .
                "}," .
                "axisY:" .
                "{" .
                    "offset:100," .
                "}";
    }

    /**
     * Template Paie Graph options
     *
     * @return string
     */
    private static function templatePieGraphOptions($key) : string
    {
        // var data = data_" . $key . ".series.map(Number).reduce((partial_sum, a) => partial_sum + a);
        return  "{" .
                    "labelInterpolationFnc: function(value)" .
                    "{
                        var series = data_" . $key . ".series.map(Number);
                        var labels = data_" . $key . ".labels;
                        var position = labels.indexOf(value);
                        var total = series.map(Number).reduce((partial_sum, a) => partial_sum + a);
                        var currentValue = series[position];
                        var percent = Math.round(currentValue / total * 100);
                        return currentValue
                            ? value + ' (' + percent + '%)'
                            : '';
                    }" .
                "}";
    }

    /**
     * Template Paie Graph options
     *
     * @param string $key
     * @return string
     */
    private static function templatePieGraphResponsive($key) : string
    {
        // var data = data_" . $key . ".series.map(Number).reduce((partial_sum, a) => partial_sum + a);
        return  "{" .
                    "labelInterpolationFnc: function(value)" .
                    "{
                        var series = data_" . $key . ".series.map(Number);
                        var labels = data_" . $key . ".labels;
                        var position = labels.indexOf(value);
                        var total = series.map(Number).reduce((partial_sum, a) => partial_sum + a);
                        var currentValue = series[position];
                        var percent = Math.round(currentValue / total * 100);
                        return currentValue
                            ? value + ' (' + percent + '%)'
                            : '';
                    }" .
                "}";
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
