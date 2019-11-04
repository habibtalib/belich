<?php

namespace Daguilarm\Belich\Components\Metrics;

use Carbon\Carbon;
use Daguilarm\Belich\Components\Metrics\Traits\Dateable;

class Labels
{
    use Dateable;

    // Filters: 'capitalize', 'lower', 'title'

    /**
     * Set an array with all the countries
     *
     * @param  string  $filter
     *
     * @return array
     */
    public static function countriesOfTheWorld(string $filter = ''): array
    {
        return static::get($filter, 'daysOfTheWeek');
    }

    /**
     * Set an array with all the days of the week
     *
     * @param  string  $filter
     *
     * @return array
     */
    public static function daysOfTheWeek(string $filter = ''): array
    {
        return static::get($filter, 'daysOfTheWeek');
    }

    /**
     * Set an array with all the days of the week (abbreviations)
     *
     * @param  string  $filter
     *
     * @return array
     */
    public static function daysOfTheWeekMin(string $filter = ''): array
    {
        return static::get($filter, 'daysOfTheWeekMin');
    }

    /**
     * Set an array with all the months of the year
     *
     * @param  string  $filter
     *
     * @return array
     */
    public static function daysOfTheMonth(): array
    {
        return static::getRangeOfDays();
    }

    /**
     * Set an array with all the daily hours
     *
     * @param  string  $filter
     *
     * @return array
     */
    public static function hoursOfTheday(): array
    {
        return static::getRangeOfHours();
    }

    /**
     * Set an array with all the months of the year
     *
     * @param  string  $filter
     *
     * @return array
     */
    public static function monthsOfTheYear(string $filter = ''): array
    {
        return static::get($filter, 'monthsOfTheYear');
    }

    /**
     * Set an array with all the months of the year (abbreviations)
     *
     * @param  string  $filter
     *
     * @return array
     */
    public static function monthsOfTheYearMin(string $filter = ''): array
    {
        return static::get($filter, 'monthsOfTheYearMin');
    }

    /**
     * Set an array with all the months of the year
     *
     * @param  int  $years
     *
     * @return array
     */
    public static function listOfYears(int $years): array
    {
        return static::getRangeOfYears($years);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    /**
     * Helper for get value from localization
     *
     * @param  string  $filter
     * @param  string  $name
     *
     * @return array
     */
    private static function get(string $filter, string $name): array
    {
        return array_map(static::arrayFilter($filter ?? 'title'), trans('belich::metrics.' . $name));
    }

    /**
     * Array filter helper
     *
     * @param  int  $value
     *
     * @return string
     */
    private static function arrayFilter(string $value): string
    {
        if ($value === 'lower') {
            return 'strtolower';
        }

        if ($value === 'capitalize') {
            return 'strtoupper';
        }

        if ($value === 'title') {
            return 'ucfirst';
        }
    }
}
