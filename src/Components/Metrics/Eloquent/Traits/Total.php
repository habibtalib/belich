<?php

namespace Daguilarm\Belich\Components\Metrics\Eloquent\Traits;

use Illuminate\Database\Eloquent\Collection;

trait Total {

    protected $query;

    /**
     * Get the total items by day
     *
     * @param string $model
     * @param string $dateField
     * @return array
     */
    public function totalByDay(string $model, string $dateField = 'created_at') : array
    {
        $total      = static::getRangeOfDays();
        $collection = self::totalResultsByType($model, 'day', $dateField);

        return $this->mapFilterByDate($total, $collection);
    }

    /**
     * Get the total items by month
     *
     * @param string $model
     * @param string $dateField
     * @return array
     */
    public function totalByMonth(string $model, string $dateField = 'created_at') : array
    {
        $total      = static::getRangeOfMonths();
        $collection = self::totalResultsByType($model, 'month', $dateField);

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
    public function totalByYears(string $model, int $years, string $dateField = 'created_at') : array
    {
        $total      = static::getRangeOfYears($years);
        $collection = self::totalResultsByType($model, 'year', $dateField);

        return $this->mapFilterByDate($total, $collection);
    }

    /**
     * Counts the total values for model by days
     *
     * @param string $dateType ['day', 'week', 'month', 'year']
     * @return Collection
     */
    private function totalResultsByType(string $dateType) : Collection
    {
        $this->query = $this->model::whereBetween($this->dateField, [$this->startDate, $this->endDate])
            ->select([
                DB::raw(strtoupper($dateType) . '(' . $this->dateField . ') as ' . $dateType),
                DB::raw('COUNT(*) as total')
            ])
            ->groupBy($dateType)
            ->orderBy($dateType, 'DESC')
            ->pluck($dateType, 'total')
            ->flip();
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
