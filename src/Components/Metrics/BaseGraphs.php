<?php

namespace Daguilarm\Belich\Components\Metrics;

use Illuminate\Http\Request;

abstract class BaseGraphs {

    /** @var object */
    public $calculate;

    /** @var array */
    public $labels;

    /** @var string */
    public $name;

    /** @var Illuminate\Http\Request */
    public $request;

    /** @var string */
    public $type;

    /** @var string */
    public $uriKey;

    /** @var string */
    public $width = 'w-1/3';

    /**
     * Set the custom metrics cards
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Illuminate\Support\Collection
     */
    public function __construct(Request $request)
    {
        $this->request    = $request;
        $this->labels     = $this->renderLabels($request);
        $this->name       = $this->name($request);
        $this->uriKey     = $this->uriKey();
        $this->calculate  = $this->calculate($request);
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

    private function renderLabels(Request $request)
    {
        return collect($this->labels($request))
            ->map(function($label) {
                return sprintf("'%s'", $label);
            })
            ->filter()
            ->implode(',');
    }
}
