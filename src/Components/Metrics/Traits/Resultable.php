<?php

namespace Daguilarm\Belich\Components\Metrics\Traits;

use Daguilarm\Belich\Components\Metrics\Traits\Dateable;
use Daguilarm\Belich\Components\Metrics\Traits\Eloquentable;

trait Resultable {

    use Dateable, Eloquentable;

    /**
     * Get the total items by day
     *
     * @param string $totals
     * @return array
     */
    public function getTotalByDay(string $model, string $dateField = 'created_at') : array
    {
        $totalDays      = static::getRangeOfDaysFromMonth();
        $collection     = $this->totalByDays($model, $dateField);
        $totalDaysReset = array_fill_keys($totalDays, 0);

        return collect($totalDaysReset)
            ->map(function($value, $day) use($collection) {
                //Search the days with results
                $search = $collection[$day] ?? 0;
                //Get the values
                return $value > 0 ? $value : $search;
            })
            ->toArray();
    }
}
