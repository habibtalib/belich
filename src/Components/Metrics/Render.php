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

    public function get()
    {
        //Set javascript key
        $key = md5($this->uriKey);

        //Format values
        $labels = $this->formatLabels($this->labels);
        $series = $this->formatSeries($this->series);

        //Set var object
        $varObject = sprintf("var data_%s={labels:[%s],series:%s};", $key, $labels, $series);

        //Set the chartist object
        $varChartist = sprintf("new Chartist.Line('.%s', data_%s, { showArea: true,low: 0});", $this->uriKey, $key);

        return sprintf('<script>%s%s</script>', $varObject, $varChartist);
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

    private function formatLabels($values) : string
    {
        $values = is_array($values) ? collect($values) : $values;

        return $values
            ->map(function($value) {
                return sprintf("'%s'", $value);
            })->implode(',');
    }

    private function formatSeries($serie) : string
    {
        $collection = is_array($serie) ? collect($serie) : $serie;

        return sprintf('[%s]', $collection->map(function($value) {
                if(is_array($value)) {
                    return $this->formatSeries($value);
                }
                return $value;
            })->implode(',')
        );
    }
}
