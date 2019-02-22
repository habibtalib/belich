<?php

namespace Daguilarm\Belich\Components\Metrics\Traits;

use Daguilarm\Belich\Components\Metrics\Traits\Dateable;
use Daguilarm\Belich\Components\Metrics\Traits\Eloquentable;

trait Resultable {

    use Dateable, Eloquentable;

    /**
     * Get the total items by day
     *
     * @param string $model
     * @param string $dateField
     * @return array
     */
    public function getTotalByDay(string $model, string $dateField = 'created_at') : array
    {
        $total      = static::getRangeOfDays();
        $collection = self::totalResultsBy($model, 'day', $dateField);

        return $this->mapFilterByDate($total, $collection);
    }

    /**
     * Get the total items by month
     *
     * @param string $model
     * @param string $dateField
     * @return array
     */
    public function getTotalByMonth(string $model, string $dateField = 'created_at') : array
    {
        $total      = static::getRangeOfMonths();
        $collection = self::totalResultsBy($model, 'month', $dateField);

        return $this->mapFilterByDate($total, $collection);
    }

    /**
     * Get the total items by month
     *
     * @param string $model
     * @param int $years
     * @param string $dateField
     * @return array
     */
    public function getTotalByYears(string $model, int $years, string $dateField = 'created_at') : array
    {
        $total      = static::getRangeOfYears($years);
        $collection = self::totalResultsBy($model, 'year', $dateField);

        return $this->mapFilterByDate($total, $collection);
    }

    /**
     * Get the total results filter by date
     *
     * @param array $totals
     * @param array $collection
     * @return array
     */
    private function mapFilterByDate(array $total, array $collection) : array
    {
        // Set the total days, months or years and reset to 0
        $total = array_fill_keys($total, 0);

        return collect($total)
            ->map(function($value, $date) use($collection) {
                //Search the days with results
                $search = $collection[$date] ?? 0;
                //Get the values
                return $value > 0 ? $value : $search;
            })
            ->toArray();
    }
}
