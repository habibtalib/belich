<?php

namespace Daguilarm\Belich\Components;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class Blade {

    public static function render(Request $request)
    {
        //Render the metric items
        $metrics = collect($request->metrics)
            ->map(function($metric) {
                if($metric) {
                    //Return the metric view
                    return view('belich::components.metrics.chart', compact('metric'))->render();
                }
            });

        //Render the cards items
        $cards = collect($request->cards)
            ->map(function($card) {
                if($card) {
                    //Return the card view
                    return $card::make();
                }
            });

        //Render values
        return $metrics->count() > 0
            ? $metrics->merge($cards)->implode('')
            : implode('', $cards->all());
    }
}

