<?php

namespace Daguilarm\Belich\Components\Metrics;

use Daguilarm\Belich\Components\Metrics\Traits\Resultable;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

abstract class Graph {

    use Resultable;

    /** @var object */
    public $calculate;

    /** @var string */
    public $color;

    /** @var array */
    public $labels;

    /** @var string */
    public $legend_h;

    /** @var string */
    public $legend_v;

    /** @var string */
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
        $this->calculate  = $this->calculate($request);
        $this->color      = $this->color($request);
        $this->labels     = $this->labels($request);
        $this->marker     = $this->marker($request);
        $this->name       = $this->name($request);
        $this->type       = $this->type($request);
        $this->uriKey     = $this->uriKey();
        $this->width      = $this->width();
        $this->withArea   = $this->withArea();
    }

    /**
     * Initialize the metrics
     */
    abstract function calculate(Request $request);

    /**
     * Set the labels
     */
    abstract function labels(Request $request);

    /**
     * Set the metric name
     */
    abstract function name(Request $request);

    /**
     * Set the default line color
     */
    private function color()
    {
        return $this->color ?? 'lightseagreen';
    }

    /**
     * Set the default line marker
     */
    private function marker()
    {
        return $this->marker ?? 'circle';
    }

    /**
     * Set the default graph type
     */
    private function type()
    {
        return $this->type ?? 'line';
    }

    /**
     * Set the default card width
     */
    private function width()
    {
        return $this->width ?? 'w-1/3';
    }

    /**
     * Add a highlight area to graph
     */
    private function withArea()
    {
        return $this->withArea ?? false;
    }
}
