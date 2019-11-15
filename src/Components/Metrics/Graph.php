<?php

namespace Daguilarm\Belich\Components\Metrics;

use Daguilarm\Belich\Contracts\ComponentContract;
use Illuminate\Http\Request;

abstract class Graph implements ComponentContract
{
    /**
     * @var object
     */
    public $calculate;

    /**
     * @var string
     */
    public $color;

    /**
     * ['area-color', 'line-color', 'title-color', 'legend-color']
     *
     * @var array
     */
    public $defineColors;

    /**
     * @var bool
     */
    public $grid;

    /**
     * @var array
     */
    public $labels;

    /**
     * @var string
     */
    public $legend_h;

    /**
     * @var string
     */
    public $legend_v;

    /**
     * ['butt', 'square', 'round']
     *
     * @var string
     */
    public $marker;

    /**
     * @var string
     */
    public $name;

    /**
     * @var Illuminate\Http\Request
     */
    public $request;

    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $uriKey;

    /**
     * @var string
     */
    public $width;

    /**
     * @var string
     */
    public $withArea;

    /**
     * Set the custom metrics cards
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function __construct(Request $request)
    {
        // Set default values
        $this->calculate = $this->calculate($request);
        $this->color = $this->color($request);
        $this->labels = $this->labels($request);
        $this->marker = $this->marker();
        $this->name = $this->name($request);
        $this->type = $this->type($request);
        $this->uriKey = $this->uriKey();
        $this->width = 'w-1/3';
        $this->withArea = $this->withArea();
    }

    /**
     * Initialize the metrics
     *
     * @return  array
     */
    abstract public function calculate(Request $request): array;

    /**
     * Set the labels
     *
     * @return  array
     */
    abstract public function labels(Request $request): array;

    /**
     * Set the metric name
     */
    abstract public function name(Request $request);

    /**
     * Set the urikey
     *
     * @return  string
     */
    abstract public function urikey(): string;

    /**
     * Set the default card width
     *
     * @param string $width
     *
     * @return self
     */
    public function width(string $width): self
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Set the default line color
     *
     * @return string
     */
    private function color(): string
    {
        return $this->color ?? 'lightseagreen';
    }

    /**
     * Set the default line color
     *
     * @return string
     */
    private function marker(): string
    {
        return $this->marker ?? 'butt';
    }

    /**
     * Set the default graph type
     *
     * @return string
     */
    private function type(): string
    {
        return $this->type ?? 'line';
    }

    /**
     * Add a highlight area to graph
     *
     * @return string
     */
    private function withArea()
    {
        return $this->withArea ?? false;
    }
}
