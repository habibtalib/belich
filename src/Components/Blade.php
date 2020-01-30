<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Components;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

final class Blade
{
    /**
     * @var Illuminate\Support\Collection
     */
    private $render;

    public function __construct()
    {
        $this->render = collect([]);
    }

    /**
     * Get the metric and the cards views
     */
    public function render(Request $request): string
    {
        // Render the metric items
        $this->renderMetrics($request);

        // Render the cards items
        $this->renderCards($request);

        return $this->render->implode('');
    }

    /**
     * Get the metric views
     */
    public function renderMetrics(Request $request): void
    {
        $metrics = collect($request->metrics)
            ->map(static function ($metric) {
                return View::make('belich::components.metrics.chart', compact('metric'))->render();
            })
            ->filter();

        $this->render = $this->render->merge($metrics);
    }

    /**
     * Get the cards views
     */
    public function renderCards(Request $request): void
    {
        $cards = collect($request->cards)
            ->map(static function ($card) {
                return View::make($card->view, compact('card'))->render();
            })
            ->filter();

        $this->render = $this->render->merge($cards);
    }
}
