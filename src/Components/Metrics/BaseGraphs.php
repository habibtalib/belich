<?php

namespace Daguilarm\Belich\Components\Metrics;

use Illuminate\Http\Request;

abstract class BaseGraphs {

    public $labels;

    public $type;

    public function __construct(Request $request)
    {
        $this->labels = $this->labels();
    }
}
