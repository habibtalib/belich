<?php

namespace Daguilarm\Belich\Components\Metrics;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class Graph {

    public static function render(Request $request)
    {
        $metrics = collect($request->metrics)
            ->map(function($metric) {
                return view('belich::metrics.card', compact('metric'))->render();
            });

        return static::hasResults($metrics);
    }

    private static function hasResults(Collection $metrics) : string
    {
        $results = ($metrics->count() > 0)
            ? $metrics->implode('')
            : null;

        return $results
            ? sprintf('<div class="flex mb-12">%s</div>', $results)
            : '';
    }
}
