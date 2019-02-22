<?php

namespace Daguilarm\Belich\Components\Metrics\Eloquent\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

trait Total {

    /**
     * Get the total items by day
     *
     * @param string $type
     * @return array
     */
    public function totalByHour(string $type = 'hour') : array
    {
        $total      = static::getRangeOfHours();
        $collection = self::totalResultsByType($type);

        return $this->mapFilterByDate($total, $collection, $type);
    }

    /**
     * Get the total items by day
     *
     * @param string $type
     * @return array
     */
    public function totalByDay(string $type = 'day') : array
    {
        $total      = static::getRangeOfDays();
        $collection = self::totalResultsByType($type);

        return $this->mapFilterByDate($total, $collection, $type);
    }

    /**
     * Get the total items by month
     *
     * @param string $type
     * @return array
     */
    public function totalByMonth(string $type = 'month') : array
    {
        $total      = static::getRangeOfMonths();
        $collection = self::totalResultsByType($type);

        return $this->mapFilterByDate($total, $collection, $type);
    }

    /**
     * Get the total items by month
     *
     * @param int $years
     * @param string $type
     * @return array
     */
    public function totalByYears(int $years, string $type = 'year') : array
    {
        $total      = static::getRangeOfYears($years);
        $collection = self::totalResultsByType($type);

        return $this->mapFilterByDate($total, $collection, $type);
    }

    /**
     * Counts the total values for model by days
     *
     * @param string $dateType ['day', 'month', 'year']
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
            ->get();
    }
}
