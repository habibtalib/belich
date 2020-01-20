<?php

namespace Daguilarm\Belich\Core\Search\Filters\Traits;

use Carbon\Carbon;

trait Date
{
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
        list($start, $end, $format, $table) = $this->handleDates($items);

        // Filter the query
        $query->when($this->condition($start, $end, $format, $table), function ($query) use ($start, $end, $format, $table) {
            // Handle the queries
            $this->queryDates($query, $format, $table, $start, $end);
        });
    }

    /**
     * Handle the queries
     *
     * @param object $query
     * @param string $format
     * @param string $table
     * @param string|null $start
     * @param string|null $end
     *
     * @return void
     */
    private function queryDates(object $query, string $format, string $table, ?string $start, ?string $end): void
    {
        // Set dates
        $start = $this->getDate($format, $start);
        $end = $this->getDate($format, $end);

        if ( ! is_null($start)) {
            $query->whereDate($table, '>=', $start);
        }

        if ( ! is_null($end)) {
            $query->whereDate($table, '<=', $end);
        }
    }

    /**
     * Handle the dates
     *
     * @param string|null $format
     * @param string|null $date
     *
     * @return array
     */
    private function getDate(?string $format, ?string $date)
    {
        if($date && $format) {
            return Carbon::createFromFormat($format, $date);
        }
        return null;
    }

    /**
     * Handle the dates
     *
     * @param array $items
     *
     * @return array
     */
    private function handleDates(array $items): array
    {
        return [
            $items[1] ?? null,
            $items[2] ?? null,
            $items[3] ?? null,
            $items[4] ?? null,
        ];
    }

    /**
     * Resolve condition
     *
     * @param string|null $start
     * @param string|null $end
     * @param string|null $format
     * @param string|null $table
     *
     * @return bool
     */
    private function condition(?string $start, ?string $end, ?string $format, ?string $table): bool
    {
        return ! is_null($start || $end) && ! is_null($format) && ! is_null($table);
    }
}
