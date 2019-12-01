<?php

namespace Daguilarm\Belich\Components\Metrics\Traits;

trait Stylable
{
    /**
     * Set the labels
     *
     * @param  object  $metric
     *
     * @return string
     */
    public function css(object $metric): string
    {
        //Set the unique key for the graph
        $key = md5($metric->uriKey);

        //Set the graph type
        $type = $metric->type;

        //Set the grid
        $grid = $metric->grid === false ? 'none' : 'var(--10)';

        $css = "
            #graph-%s-%s .ct-grids line{stroke:%s}
            #graph-%s-%s .ct-label{font-weight:bold;fill:%s}
            #graph-%s-%s .ct-series .ct-bar,
            #graph-%s-%s .ct-series .ct-line,
            #graph-%s-%s .ct-series .ct-slice-donut {
                stroke:%s;
                stroke-linecap:%s;
            }
            #graph-%s-%s .ct-series .ct-area {
                fill:%s;
            }
            #graph-%s-%s .ct-series .ct-point {
              stroke:%s;
              stroke-linecap:%s;
            }
        ";

        return sprintf(
            $css,
            $type, $key, $grid,
            $type, $key, $metric->defineColor['label-color'] ?? 'gray',
            $type, $key,
            $type, $key,
            $type, $key,
            $metric->defineColor['line-color'] ?? $metric->color,
            $metric->marker,
            $type, $key,
            $metric->defineColor['area-color'] ?? $metric->color,
            $type, $key,
            $metric->defineColor['line-color'] ?? $metric->color,
            $metric->marker
        );
    }
}
