<?php

namespace Daguilarm\Belich\Components\Metrics\Eloquent\Traits;

use Carbon\Carbon;
use Daguilarm\Belich\Components\Metrics\Traits\Dateable;

trait DatesForHumans
{
    use Dateable;

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
    public function startDate(Carbon $date) : self
    {
        $this->startDate = $this->filterDateFormat($date);

        return $this;
    }

    /**
     * Set the end date for the query
     *
     * @return self
     */
    public function endDate(Carbon $date) : self
    {
        $this->endDate = $this->filterDateFormat($date);

        return $this;
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
    public function toDay() : self
    {
        $this->startDate = Carbon::now()->startOfDay();
        $this->endDate   = Carbon::now()->endOfDay();

        return $this;
    }

    /**
     * Set one specific day for the query
     *
     * @param int $day
     * @param int $month
     * @param int $year
     * @return self
     */
    public function oneDay(int $day, int $month, int $year) : self
    {
        $this->startDate = Carbon::createFromDate($year, $month, $day, config('app.timezone'))->startOfDay();
        $this->endDate   = Carbon::createFromDate($year, $month, $day, config('app.timezone'))->endOfDay();

        return $this;
    }

    /**
     * Set last days for the query
     *
     * @param int $number [Set the number of days]
     * @return self
     */
    public function lastDays(int $number) : self
    {
        $this->startDate = Carbon::now()->subDay($number);
        $this->endDate   = Carbon::now()->endOfDay();

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
    public function thisWeek() : self
    {
        $this->startDate = Carbon::now()->startOfWeek();
        $this->endDate   = Carbon::now()->endOfDay();

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
    public function thisMonth() : self
    {
        $this->startDate = static::getFirstDayOfTheMonth()->startOfDay();
        $this->endDate   = Carbon::now()->endOfDay();

        return $this;
    }

    /**
     * Set last month for the query
     *
     * @return self
     */
    public function lastMonth() : self
    {
        $this->startDate = static::getFirstDayOfTheLastMonth()->startOfDay();
        $this->endDate   = static::getLastDayOfTheLastMonth()->endOfDay();

        return $this;
    }

    /**
     * Set last months for the query
     *
     * @param int $number [Set the number of months]
     * @return self
     */
    public function lastMonths(int $number) : self
    {
        $this->startDate = Carbon::now()->subMonth($number)->startOfDay();
        $this->endDate   = Carbon::now()->endOfDay();

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
    public function thisYear() : self
    {
        $this->startDate = Carbon::now()->firstOfYear()->startOfDay();
        $this->endDate   = Carbon::now()->endOfDay();

        return $this;
    }

    /**
     * Set list of years for the query
     *
     * @return self
     */
    public function lastYear() : self
    {
        $this->lastYears(1);

        return $this;
    }

    /**
     * Set list of years for the query
     *
     * @return self
     */
    public function lastYears(int $years) : self
    {
        $this->startDate = Carbon::now()->subYear($years)->startOfDay();
        $this->endDate   = Carbon::now()->endOfDay();

        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Operations
    |--------------------------------------------------------------------------
    */

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
        if(DateTime::createFromFormat('Y-m-d', $date, config('app.timezone'))) {
            return DateTime::createFromFormat('Y-m-d', $date, config('app.timezone'));
        }

        //European format
        if(DateTime::createFromFormat('d/m/Y', $date, config('app.timezone'))) {
            return DateTime::createFromFormat('d/m/Y', $date, config('app.timezone'));
        }

        //English format
        if(DateTime::createFromFormat('Y/m/d', $date, config('app.timezone'))) {
            return DateTime::createFromFormat('Y/m/d', $date, config('app.timezone'));
        }
    }

}
