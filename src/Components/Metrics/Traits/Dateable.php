<?php

namespace Daguilarm\Belich\Components\Metrics\Traits;

use Carbon\Carbon;

trait Dateable {

    /**
     * Get an array with all the days of the current month
     *
     * @return array
     */
    protected static function getRangeOfDaysFromMonth() : array
    {
        foreach(range(1, static::getDaysOfTheMonth()) as $day) {
            $range[] = $day;
        };

        return $range;
    }

    /**
     * Get an array with all the month of the year
     *
     * @return array
     */
    protected static function getRangeOfMonthFromYear() : array
    {
        foreach(range(1, 12) as $month) {
            $range[] = $month;
        };

        return $range;
    }

    /**
     * Get an total number of days from the current month
     *
     * @return int
     */
    protected static function getDaysOfTheMonth() : int
    {
        return Carbon::now()->daysInMonth;
    }

    /**
     * Get an array with all the month of the year
     *
     * @return Carbon\Carbon
     */
    protected static function getFirsDayOfTheMonth() : Carbon
    {
        return new Carbon('first day of this month');
    }

    /**
     * Set the start date for the query
     *
     * @return self
     */
    protected function startDate(Carbon $date) : self
    {
        $this->startDate = $date;

        return $this;
    }

    /**
     * Set the end date for the query
     *
     * @return self
     */
    protected function endDate(Carbon $date) : self
    {
        $this->endDate = $date;

        return $this;
    }
}
