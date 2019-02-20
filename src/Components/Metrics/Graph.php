<?php

namespace Daguilarm\Belich\Components\Metrics;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class Graph {

    /**
     * Render the metric card
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public static function render(Request $request) : string
    {
        //Render the metric view
        $metrics = collect($request->metrics)
            ->map(function($metric) {
                return view('belich::metrics.card', compact('metric'))->render();
            });

        return static::hasResults($metrics);
    }

    /**
     * Check for results
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    private static function hasResults(Collection $metrics) : string
    {
        //If results...
        $results = ($metrics->count() > 0)
            ? $metrics->implode('')
            : null;

        return $results
            ? sprintf('<div class="flex mb-12">%s</div>', $results)
            : '';
    }
}
