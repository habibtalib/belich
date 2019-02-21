<?php

namespace Daguilarm\Belich\Components\Metrics\Traits;

use Carbon\Carbon;
use Daguilarm\Belich\Components\Metrics\Traits\Dateable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

trait Eloquentable {

    use Dateable;

    /** @var object */
    protected $startDate;

    /** @var object */
    protected $endDate;

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    /**
     * Counts the values for model at the range and previous range
     *
     * @param Illuminate\Database\Eloquent\Model $model Eloquent model
     * @return Illuminate\Database\Eloquent\Collection
     */
    private function totalByDays(string $model, string $dateField = 'created_at')
    {
        return $model::whereBetween($dateField, [$this->startDate, $this->endDate])
            ->select([
                DB::raw('Day(created_at) as day'),
                DB::raw('COUNT(*) as total')
            ])
            ->groupBy('day')
            ->orderBy('day', 'DESC')
            ->pluck('day', 'total')
            ->flip()
            ->toArray();
    }
}
