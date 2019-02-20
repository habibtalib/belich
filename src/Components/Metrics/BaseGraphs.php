<?php

namespace Daguilarm\Belich\Components\Metrics;

use Illuminate\Http\Request;

abstract class BaseGraphs {

    /** @var array */
    protected $labels;

    /** @var Illuminate\Http\Request */
    protected $request;

    /** @var string */
    protected $type;

    /**
     * Set the custom metrics cards
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Illuminate\Support\Collection
     */
    public function __construct(Request $request)
    {
        $this->labels = $this->labels();
        $this->request = $this->request;
    }

    /**
     * Initialize the metrics
     */
    abstract function handle();

    /**
     * Set the labels
     */
    abstract function labels();
}
