<?php

namespace Daguilarm\Belich\Components\Metrics;

use Illuminate\Http\Request;

abstract class Graph {

    /** @var object */
    public $calculate;

    /** @var string */
    public $color;

    /** @var array */
    public $labels;

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
        $this->uriKey     = $this->uriKey();
        $this->width     = $this->width();
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
     * Set the default card width
     */
    private function width()
    {
        return $this->width ?? 'w-1/3';
    }
}
