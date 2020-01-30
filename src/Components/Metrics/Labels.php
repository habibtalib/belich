<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Components\Metrics;

use Daguilarm\Belich\Components\Metrics\Traits\Dateable;

final class Labels
{
    use Dateable;

    /**
     * Set an array with all the countries
     */
    public static function countriesOfTheWorld(string $filter = ''): array
    {
        return static::get($filter, 'daysOfTheWeek');
    }

    /**
     * Set an array with all the days of the week
     */
    public static function daysOfTheWeek(string $filter = ''): array
    {
        return static::get($filter, 'daysOfTheWeek');
    }

    /**
     * Set an array with all the days of the week (abbreviations)
     */
    public static function daysOfTheWeekMin(string $filter = ''): array
    {
        return static::get($filter, 'daysOfTheWeekMin');
    }

    /**
     * Set an array with all the months of the year
     */
    public static function daysOfTheMonth(): array
    {
        return static::getRangeOfDays();
    }

    /**
     * Set an array with all the daily hours
     */
    public static function hoursOfTheday(): array
    {
        return static::getRangeOfHours();
    }

    /**
     * Set an array with all the months of the year
     */
    public static function monthsOfTheYear(string $filter = ''): array
    {
        return static::get($filter, 'monthsOfTheYear');
    }

    /**
     * Set an array with all the months of the year (abbreviations)
     */
    public static function monthsOfTheYearMin(string $filter = ''): array
    {
        return static::get($filter, 'monthsOfTheYearMin');
    }

    /**
     * Set an array with all the months of the year
     */
    public static function listOfYears(int $years): array
    {
        return static::getRangeOfYears($years);
    }

    /**
     * Helper for get value from localization
     */
    private static function get(string $filter, string $name): array
    {
        return array_map(static::arrayFilter($filter ?? 'title'), trans('belich::metrics.' . $name));
    }

    /**
     * Array filter helper
     */
    private static function arrayFilter(string $value): string
    {
        $filter = [
            'lower' => 'strtolower',
            'capitalize' => 'strtoupper',
            'title' => 'ucfirst',
        ];

        if (in_array($value, array_keys($filter))) {
            return $filter[$value];
        }
    }
}
