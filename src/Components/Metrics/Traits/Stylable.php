<?php

namespace Daguilarm\Belich\Components\Metrics\Traits;

trait Stylable {
    /**
     * Set the labels
     *
     * @param  object  $metric
     * @return string
     */
    public function css(object $metric) : string
    {
        //Set the unique key for the graph
        $key = md5($metric->uriKey);

        return  sprintf(
            '#graph-%s .ct-grids line{stroke: var(--10)}' .
            '#graph-%s .ct-label{font-weight:bold;fill:white}' .
            '#graph-%s .ct-series .ct-bar,' .
            '#graph-%s .ct-series .ct-line,' .
            '#graph-%s .ct-series .ct-point,' .
            '#graph-%s .ct-series .ct-slice-donut' .
            '{' .
                'stroke:%s;' .
                'stroke-linecap:%s;' .
            '}' .
            '#graph-%s .ct-series .ct-area' .
            '{' .
                'fill:%s;' .
            '}',
            $key,
            $key,
            $key,
            $key,
            $key,
            $key,
            $metric->defineColor['line-color'] ?? $metric->color,
            $metric->marker,
            $key,
            $metric->defineColor['area-color'] ?? $metric->color
        );
    }
}
