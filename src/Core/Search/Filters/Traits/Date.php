<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Core\Search\Filters\Traits;

use Carbon\Carbon;

trait Date
{
    /**
     * Handle the dates
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
     */
    private function condition(?string $start, ?string $end, ?string $format, ?string $table): bool
    {
        return ! is_null($start || $end) && ! is_null($format) && ! is_null($table);
    }
}
