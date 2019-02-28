<?php

namespace Daguilarm\Belich\Components;

use Illuminate\Http\Request;

class Blade {

    public static function render(Request $request)
    {
        //Render the metric view
        return collect($request->metrics)
            ->map(function($metric) {
                return view('belich::components.metrics.chart', compact('metric'))->render();
            })
            ->merge(collect($request->cards)->map(function($card) {
                    return $card::make();
                })
            )
            ->implode('');
    }
}

