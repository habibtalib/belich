<?php

namespace Daguilarm\Belich\Components\Metrics\Traits;

use Carbon\Carbon;
use Daguilarm\Belich\Components\Metrics\Traits\Dateable;

trait DatesForHumans {

    /*
    |--------------------------------------------------------------------------
    | Base
    |--------------------------------------------------------------------------
    */

    /**
     * Set the start date for the query
     *
     * @return self
     */
    protected function startDate(Carbon $date) : self
    {
        $this->startDate = $this->filterDateFormat($date);

        return $this;
    }

    /**
     * Set the end date for the query
     *
     * @return self
     */
    protected function endDate(Carbon $date) : self
    {
        $this->endDate = $this->filterDateFormat($date);

        return $this;
    }

    /**
     * Filter date base on format
     *
     * @param mixed $date
     * @return self
     */
    private function filterDateFormat($date) : Carbon
    {
        //Carbon format
        if($date instanceof Carbon) {
            return $date;
        }

        //Sql format
        if(DateTime::createFromFormat('Y-m-d', $date)) {
            return DateTime::createFromFormat('Y-m-d', $date);
        }

        //European format
        if(DateTime::createFromFormat('d/m/Y', $date)) {
            return DateTime::createFromFormat('d/m/Y', $date);
        }

        //English format
        if(DateTime::createFromFormat('Y/m/d', $date)) {
            return DateTime::createFromFormat('Y/m/d', $date);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | For Days
    |--------------------------------------------------------------------------
    */

    /**
     * Set today for the query
     *
     * @return self
     */
    protected function toDay() : self
    {
        $this->startDate = now()->startOfDay();
        $this->endDate   = now();

        return $this;
    }

    /**
     * Set last days for the query
     *
     * @param int $number [Set the number of days]
     * @return self
     */
    protected function lastDays(int $number) : self
    {
        $this->startDate = now()->subDay($number);
        $this->endDate   = now();

        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | For Weeks
    |--------------------------------------------------------------------------
    */

    /**
     * Set the last week for the query
     *
     * @return self
     */
    protected function thisWeek() : self
    {
        $this->startDate = now()->startOfWeek();
        $this->endDate   = now();

        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | For Months
    |--------------------------------------------------------------------------
    */

    /**
     * Set this month the query
     *
     * @return self
     */
    protected function thisMonth() : self
    {
        $this->startDate = static::getFirstDayOfTheMonth();
        $this->endDate   = now();

        return $this;
    }

    /**
     * Set last month for the query
     *
     * @return self
     */
    protected function lastMonth() : self
    {
        $this->startDate = static::getFirstDayOfTheLastMonth();
        $this->endDate   = static::getLastDayOfTheLastMonth();

        return $this;
    }

    /**
     * Set last months for the query
     *
     * @param int $number [Set the number of months]
     * @return self
     */
    protected function lastMonths(int $number) : self
    {
        $this->startDate = now()->subMonth($number);
        $this->endDate   = now();

        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | For Years
    |--------------------------------------------------------------------------
    */

    /**
     * Set this year for the query
     *
     * @return self
     */
    protected function thisYear() : self
    {
        $this->startDate = now()->firstOfYear();
        $this->endDate   = now();

        return $this;
    }

    /**
     * Set list of years for the query
     *
     * @return self
     */
    protected function lastYears(int $years) : self
    {
        $this->startDate = now()->subYear($years);
        $this->endDate   = now();

        return $this;
    }
}
