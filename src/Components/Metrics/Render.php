<?php

namespace Daguilarm\Belich\Components\Metrics;

use Daguilarm\Belich\Components\Metrics\Css;
use Daguilarm\Belich\Components\Metrics\Javascript;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class Render {

    use Css, Javascript;

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
                return view('belich::metrics.card', compact('metric'))->render();
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
    private function graphSelector($type, $key)
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
    private function lineGraph($key)
    {
        $withArea = $this->withArea ? "{showArea: true, low: 0}" : '';

        return sprintf("new Chartist.Line('.%s',data_%s,%s);", $this->uriKey, $key, $withArea);
    }

    private function barGraph($key) {
        $options = "seriesBarDistance:10,axisX:{offset:30},axisY:{offset:40,labelInterpolationFnc:function(value){return value},scaleMinSpace:15}";

        return sprintf("new Chartist.Bar('.%s',data_%s,{%s});", $this->uriKey, $key, $options);
    }

    private function horizontalBarGraph($key) {
        $barGraph = substr($this->barGraph($key, $labelValue), 0, -3);
        $options = "reverseData:true,horizontalBars:true,seriesBarDistance:10,axisX:{offset:30},axisY:{offset:100,labelInterpolationFnc:function(value){return value},scaleMinSpace:15}";

        return sprintf("new Chartist.Bar('.%s',data_%s,{%s});", $this->uriKey, $key, $options);
    }

    private function pieGraph($key) {
        $options = "{donut:true,donutWidth:50,donutSolid:true,startAngle:270,total:200,showLabel:false}";

        $data = "{labels:['monday','tuesday','wednesday','thursday','friday','saturday','sunday'],series:['37','41','45','19','43','14','29']}";
        return sprintf("new Chartist.Pie('.%s',%s,%s);", $this->uriKey, $data, $options);
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
