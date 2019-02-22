<?php

namespace Daguilarm\Belich\Components\Metrics\Eloquent\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

trait Total {

    /**
     * Get the total items by day
     *
     * @return array
     */
    public function totalByDay() : array
    {
        $total      = static::getRangeOfDays();
        $collection = self::totalResultsByType('day');

        return $this->mapFilterByDate($total, $collection);
    }

    /**
     * Get the total items by month
     *
     * @return array
     */
    public function totalByMonth() : array
    {
        $total      = static::getRangeOfMonths();
        $collection = self::totalResultsByType('month');

        return $this->mapFilterByDate($total, $collection);
    }

    /**
     * Get the total items by month
     *
     * @param int $years
     * @return array
     */
    public function totalByYears(int $years) : array
    {
        $total      = static::getRangeOfYears($years);
        $collection = self::totalResultsByType('year');

        return $this->mapFilterByDate($total, $collection);
    }

    /**
     * Counts the total values for model by days
     *
     * @param string $dateType ['day', 'week', 'month', 'year']
     * @return Collection
     */
    private function totalResultsByType(string $dateType)
    {
        return $this->model::whereBetween($this->dateTable, [$this->startDate, $this->endDate])
            ->select([
                DB::raw(strtoupper($dateType) . '(' . $this->dateTable . ') as ' . $dateType),
                DB::raw('COUNT(*) as total')
            ])
            ->groupBy($dateType)
            ->orderBy($dateType, 'DESC')
            ->pluck($dateType, 'total')
            ->flip()
            ->toArray();
    }

    /**
     * Get the total results filter by date and reset the value to 0 if no results
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
