<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Components\Metrics;

use Daguilarm\Belich\Contracts\ComponentContract;
use Illuminate\Http\Request;

abstract class Graph implements ComponentContract
{
    public array $calculate;
    public string $color;
    public array $labels;
    public string $legend_h = '';
    public string $legend_v = '';
    public string $name;
    public string $type;
    public string $uriKey;
    public string $width = 'w-1/3';
    public bool $withArea = false;
    public bool $grid = false;

    /**
     * @var Illuminate\Http\Request
     */
    public $request;

    /**
     * ['area-color', 'line-color', 'title-color', 'legend-color']
     *
     * @var array
     */
    public $defineColors;

    /**
     * ['butt', 'square', 'round']
     */
    public string $marker;

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
        $this->withArea = $this->withArea();
    }

    /**
     * Make metrics calculations
     */
    abstract public function calculate(Request $request): array;

    /**
     * Set the labels
     */
    abstract public function labels(Request $request): array;

    /**
     * Set the metric name
     */
    abstract public function name(Request $request);

    /**
     * Set the urikey
     */
    abstract public function urikey(): string;

    /**
     * Set the default card width
     */
    public function width(string $width): self
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Set the default line color
     */
    private function color(): string
    {
        return $this->color ?? 'gray';
    }

    /**
     * Set the default line color
     */
    private function marker(): string
    {
        return $this->marker ?? 'butt';
    }

    /**
     * Set the default graph type
     */
    private function type(): string
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
