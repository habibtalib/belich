<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Components\Metrics\Eloquent\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

trait Sql
{
    /**
     * Get the results by type and dateType from storage
     *
     * @param string $dateType ['day', 'month', 'year']
     */
    private function getDataFromStorage(string $dateType): Collection
    {
        return $this->model::whereBetween($this->dateTable, [$this->startDate, $this->endDate])
            ->select([
                DB::raw(strtoupper($dateType) . '(' . $this->dateTable . ') as ' . $dateType),
                DB::raw('COUNT(*) as total'),
            ])
            ->groupBy($dateType)
            ->orderBy($dateType, 'DESC')
            ->when(is_numeric($this->take), function ($query) {
                return $query->take($this->take);
            })
            ->get();
    }

    /**
     * Get the total results filter by date and reset the value to 0 if no results
     *
     * @param string $dateType ['day', 'month', 'year']
     */
    private function resultsByDate(array $total, string $dateType): array
    {
        //Set the total days, months or years and reset to 0
        $total = array_fill_keys($total, 0);

        //Get the data from cache or storage
        $sql = $this->parseCache($dateType);

        return collect($total)
            ->map(static function ($index, $date) use ($sql, $dateType) {
                //Search the days with results
                return $sql->where($dateType, $date)->first()->total ?? 0;
            })->toArray();
    }
}
