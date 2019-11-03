<?php

namespace Daguilarm\Belich\Components;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;

class Blade
{
    /**
     * Get the metric and the cards views
     *
     * @param Illuminate\Http\Request $request
     *
     * @return string
     */
    public function render(Request $request)
    {
        //Render the metric items
        $metrics = $this->renderMetrics($request);

        //Render the cards items
        $cards = $this->renderCards($request);

        //Render values
        return $metrics->count() > 0
            ? $metrics->merge($cards)->implode('')
            : $cards;
    }

    /**
     * Get the metric views
     *
     * @param Illuminate\Http\Request $request
     *
     * @return string
     */
    public function renderMetrics(Request $request)
    {
        return collect($request->metrics)
            ->map(static function ($metric) {
                if ($metric) {
                    //Return the metric view
                    return View::make('belich::components.metrics.chart', compact('metric'))->render();
                }
            });
    }

    /**
     * Get the cards views
     *
     * @param Illuminate\Http\Request $request
     *
     * @return string
     */
    public function renderCards(Request $request)
    {
        return collect($request->cards)
            ->map(static function ($card) {
                if ($card) {
                    //Return the card view
                    return View::make($card->view)->with($card->withMeta);
                }
            });
    }
}
