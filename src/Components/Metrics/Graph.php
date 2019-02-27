<?php

namespace Daguilarm\Belich\Components\Metrics;

use Daguilarm\Belich\Components\Metrics\Eloquent\Connection;
use Daguilarm\Belich\Components\Metrics\Traits\Resultable;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

abstract class Graph {

    /** @var object */
    public $calculate;

    /** @var string */
    public $color;

    /** @var array ['area-color', 'line-color', 'title-color', 'legend-color'] */
    public $defineColors;

    /** @var bool */
    public $grid;

    /** @var array */
    public $labels;

    /** @var string */
    public $legend_h;

    /** @var string */
    public $legend_v;

    /** @var string ['butt', 'square', 'round']*/
    public $marker;

    /** @var string */
    public $name;

    /** @var Illuminate\Http\Request */
    public $request;

    /** @var string */
    public $type;

    /** @var string */
    public $uriKey;

    /** @var string */
    public $width;

    /** @var string */
    public $withArea;

    /**
     * Set the custom metrics cards
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Illuminate\Support\Collection
     */
    public function __construct(Request $request)
    {
        // Set default values
        $this->calculate = $this->calculate($request);
        $this->color     = $this->color($request);
        $this->labels    = $this->labels($request);
        $this->marker    = $this->marker();
        $this->name      = $this->name($request);
        $this->type      = $this->type($request);
        $this->uriKey    = $this->uriKey();
        $this->width     = 'w-1/3';
        $this->withArea  = $this->withArea();
    }

    /**
     * Initialize the metrics
     *
     */
    abstract function calculate(Request $request) : array;

    /**
     * Set the labels
     */
    abstract function labels(Request $request) : array;

    /**
     * Set the metric name
     */
    abstract function name(Request $request);

    /**
     * Set the urikey
     */
    abstract function urikey() : string;

    /**
     * Set the default card width
     *
     * @param string $width
     * @return self
     */
    public function width(string $width) : self
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Set the default line color
     */
    private function color()
    {
        return $this->color ?? 'lightseagreen';
    }

    /**
     * Set the default line color
     */
    private function marker()
    {
        return $this->marker ?? 'butt';
    }

    /**
     * Set the default graph type
     */
    private function type()
    {
        return $this->type ?? 'line';
    }

    /**
     * Add a highlight area to graph
     */
    private function withArea()
    {
        return $this->withArea ?? false;
    }
}
