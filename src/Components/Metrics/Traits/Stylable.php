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
        $key = md5($metric->uriKey);

        return  sprintf(
            '#graph-%s .ct-series .ct-bar,' .
            '#graph-%s .ct-series .ct-line,' .
            '#graph-%s .ct-series .ct-point,' .
            '#graph-%s .ct-series .ct-slice-donut' .
            '{' .
                'stroke:%s;' .
                'stroke-linecap:%s;' .
            '}',
            $key,
            $key,
            $key,
            $key,
            $metric->color,
            $metric->marker
        );
    }
}
