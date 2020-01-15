<?php

namespace Daguilarm\Belich\Core\Search\Filters\Traits;

trait Date
{
    private $humanDates = [
        'today',
        'nextDay',
        'nextWeek',
        'nextMonth',
        'nextYear',
        'yesterday',
        'lastWeek',
        'lastMonth',
        'lastYear',
    ];

    /**
     * Handle the dates
     *
     * @param object $query
     * @param array $items
     *
     * @return object
     */
    public function date(object $query, array $items)
    {
        list($dateStart, $dateEnd, $format) = $this->handleDates($items);

        ddd($dateStart, $dateEnd, $format);
    }

    /**
     * Handle the dates
     *
     * @return array
     */
    private function handleDates($items): array
    {
        return array_merge(
            $this->getDates($items),
            $this->getFormat($items)
        );
    }

    /**
     * Get the dates
     *
     * @return array
     */
    private function getDates($items): array
    {
        return explode('/', $items[2]);
    }

    /**
     * Get the format
     *
     * @return array
     */
    private function getFormat($items): array
    {
        $format = $items[3];

        return is_array($format)
            ? $format
            : [$format];
    }

    /**
     * Resolve condition
     *
     * @return bool
     */
    private function condition($date, $items): bool
    {
        return isset($date) && is_array($date) && isset($items[3]);
    }
}
