<?php

namespace Daguilarm\Belich\Components;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;

final class Blade
{
    /**
     * Get the metric and the cards views
     *
     * @param Illuminate\Http\Request $request
     *
     * @return string
     */
    public function render(Request $request): string
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
     * @return Illuminate\Support\Collection
     */
    public function renderMetrics(Request $request): Collection
    {
        return collect($request->metrics)
            ->map(static function ($metric) {
                return $metric
                    ? View::make('belich::components.metrics.chart', compact('metric'))->render()
                    : null;
            });
    }

    /**
     * Get the cards views
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Support\Collection
     */
    public function renderCards(Request $request): Collection
    {
        return collect($request->cards)
            ->map(static function ($card) {
                return $card
                    ? View::make($card->view)->with($card->withMeta)
                    : null;
            });
    }
}
