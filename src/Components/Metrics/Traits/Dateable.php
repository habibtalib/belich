<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Components\Metrics\Traits;

use Carbon\Carbon;

trait Dateable
{
    /**
     * Set an array with all the daily hours
     */
    public static function getRangeOfHours(): array
    {
        $range = [];

        foreach (range(1, 24) as $hour) {
            $range[] = $hour;
        }

        return $range;
    }

    /**
     * Get an array with all the days of the current month
     */
    protected static function getRangeOfDays(): array
    {
        $range = [];

        foreach (range(1, static::getDaysOfTheMonth()) as $day) {
            $range[] = $day;
        }

        return $range;
    }

    /**
     * Get an array with all the month of the year
     */
    protected static function getRangeOfMonths(): array
    {
        $range = [];

        foreach (range(1, 12) as $month) {
            $range[] = $month;
        }

        return $range;
    }

    /**
     * Get an array with all the month of the year
     */
    protected static function getRangeOfYears(int $years): array
    {
        $firstYear = now()->subYear($years)->year;
        $lastYear = now()->year;
        $range = [];

        foreach (range($firstYear, $lastYear) as $month) {
            $range[] = $month;
        }

        return $range;
    }

    /**
     * Get an total number of days from the current month
     */
    protected static function getDaysOfTheMonth(): int
    {
        return Carbon::now()->daysInMonth;
    }

    /**
     * Get the first day of the current month
     */
    protected static function getFirstDayOfTheMonth(): Carbon
    {
        return new Carbon('first day of this month');
    }

    /**
     * Get the first day of the last month
     */
    protected static function getLastDayOfTheMonth(): Carbon
    {
        return new Carbon('last day of this month');
    }

    /**
     * Get the first day of the last month
     */
    protected static function getFirstDayOfTheLastMonth(): Carbon
    {
        return new Carbon('first day of last month');
    }

    /**
     * Get the first day of the last month
     */
    protected static function getLastDayOfTheLastMonth(): Carbon
    {
        return new Carbon('last day of last month');
    }

    /**
     * Set the start date for the query
     */
    protected function startDate(Carbon $date): self
    {
        $this->startDate = $date;

        return $this;
    }

    /**
     * Set the end date for the query
     */
    protected function endDate(Carbon $date): self
    {
        $this->endDate = $date;

        return $this;
    }

    /**
     * Set this month the query
     */
    protected function thisMonth(): self
    {
        $this->startDate = static::getFirstDayOfTheMonth();
        $this->endDate = now();

        return $this;
    }

    /**
     * Set last month for the query
     */
    protected function lastMonth(): self
    {
        $this->startDate = static::getFirstDayOfTheLastMonth();
        $this->endDate = static::getLastDayOfTheLastMonth();

        return $this;
    }

    /**
     * Set last months for the query
     */
    protected function lastMonths(int $number = 3): self
    {
        $this->startDate = now()->subMonth($number);
        $this->endDate = now();

        return $this;
    }

    /**
     * Set the last week for the query
     */
    protected function thisWeek(): self
    {
        $this->startDate = now()->startOfWeek();
        $this->endDate = now();

        return $this;
    }

    /**
     * Set this year for the query
     */
    protected function thisYear(): self
    {
        $this->startDate = now()->firstOfYear();
        $this->endDate = now();

        return $this;
    }

    /**
     * Set list of years for the query
     */
    protected function lastYears(int $years): self
    {
        $this->startDate = now()->subYear($years);
        $this->endDate = now();

        return $this;
    }

    /**
     * Set today for the query
     */
    protected function toDay(): self
    {
        $this->startDate = now()->startOfDay();
        $this->endDate = now();

        return $this;
    }
}
