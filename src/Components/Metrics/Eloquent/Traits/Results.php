<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Components\Metrics\Eloquent\Traits;

trait Results
{
    /**
     * Get the total items by day
     */
    public function totalByHour(string $dateType = 'hour', string $type = 'total'): array
    {
        $total = static::getRangeOfHours();

        return $this->resultsByDate($total, $dateType, $type);
    }

    /**
     * Get the total items by day
     *
     * @param string $dateType ['day', 'month', 'year']
     * @param string $type ['average', 'total', 'trent']
     */
    public function totalByDay(string $dateType = 'day', string $type = 'total'): array
    {
        $total = static::getRangeOfDays();

        return $this->resultsByDate($total, $dateType, $type);
    }

    /**
     * Get the total items by month
     *
     * @param string $dateType ['day', 'month', 'year']
     * @param string $type ['average', 'total', 'trent']
     */
    public function totalByMonth(string $dateType = 'month', string $type = 'total'): array
    {
        $total = static::getRangeOfMonths();

        return $this->resultsByDate($total, $dateType, $type);
    }

    /**
     * Get the total items by month
     *
     * @param int $years
     * @param string $dateType ['day', 'month', 'year']
     * @param string $type ['average', 'total', 'trent']
     */
    public function totalByYears(int $years, string $dateType = 'year', string $type = 'total'): array
    {
        $total = static::getRangeOfYears($years);

        return $this->resultsByDate($total, $dateType, $type);
    }
}
