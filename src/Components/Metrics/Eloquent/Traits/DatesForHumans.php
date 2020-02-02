<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Components\Metrics\Eloquent\Traits;

use Carbon\Carbon;
use Daguilarm\Belich\Components\Metrics\Traits\Dateable;

trait DatesForHumans
{
    use Dateable;

    private array $dateFormat = [
        'Y-m-d',
        'd/m/Y',
        'Y/m/d',
    ];

    /**
     * Set the start date for the query
     */
    public function startDate(Carbon $date): self
    {
        $this->startDate = $this->filterDateFormat($date);

        return $this;
    }

    /**
     * Set the end date for the query
     */
    public function endDate(Carbon $date): self
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
     */
    public function toDay(): self
    {
        $this->startDate = Carbon::now()->startOfDay();
        $this->endDate = Carbon::now()->endOfDay();

        return $this;
    }

    /**
     * Set one specific day for the query
     */
    public function oneDay(int $day, int $month, int $year): self
    {
        $this->startDate = Carbon::createFromDate($year, $month, $day, config('app.timezone'))->startOfDay();
        $this->endDate = Carbon::createFromDate($year, $month, $day, config('app.timezone'))->endOfDay();

        return $this;
    }

    /**
     * Set last days for the query
     *
     * @param int $number [Set the number of days]
     */
    public function lastDays(int $number): self
    {
        $this->startDate = Carbon::now()->subDay($number);
        $this->endDate = Carbon::now()->endOfDay();

        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | For Weeks
    |--------------------------------------------------------------------------
    */

    /**
     * Set the last week for the query
     */
    public function thisWeek(): self
    {
        $this->startDate = Carbon::now()->startOfWeek();
        $this->endDate = Carbon::now()->endOfDay();

        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | For Months
    |--------------------------------------------------------------------------
    */

    /**
     * Set this month the query
     */
    public function thisMonth(): self
    {
        $this->startDate = static::getFirstDayOfTheMonth()->startOfDay();
        $this->endDate = Carbon::now()->endOfDay();

        return $this;
    }

    /**
     * Set last month for the query
     */
    public function lastMonth(): self
    {
        $this->startDate = static::getFirstDayOfTheLastMonth()->startOfDay();
        $this->endDate = static::getLastDayOfTheLastMonth()->endOfDay();

        return $this;
    }

    /**
     * Set last months for the query
     *
     * @param int $number [Set the number of months]
     */
    public function lastMonths(int $number): self
    {
        $this->startDate = Carbon::now()->subMonth($number)->startOfDay();
        $this->endDate = Carbon::now()->endOfDay();

        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | For Years
    |--------------------------------------------------------------------------
    */

    /**
     * Set this year for the query
     */
    public function thisYear(): self
    {
        $this->startDate = Carbon::now()->firstOfYear()->startOfDay();
        $this->endDate = Carbon::now()->endOfDay();

        return $this;
    }

    /**
     * Set list of years for the query
     */
    public function lastYear(): self
    {
        $this->lastYears(1);

        return $this;
    }

    /**
     * Set list of years for the query
     */
    public function lastYears(int $years): self
    {
        $this->startDate = Carbon::now()->subYear($years)->startOfDay();
        $this->endDate = Carbon::now()->endOfDay();

        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Operations
    |--------------------------------------------------------------------------
    */

    /**
     * Filter date base on format
     */
    private function filterDateFormat($date): Carbon
    {
        //Carbon format
        if ($date instanceof Carbon) {
            return $date;
        }

        // Validate the correct format
        return collect($this->dateFormat)
            ->map(static function ($format) use ($date) {
                if (DateTime::createFromFormat($format, $date, config('app.timezone'))) {
                    return DateTime::createFromFormat($format, $date, config('app.timezone'));
                }
            });
    }
}
