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
     * Counts the total values for model by days
     *
     * @param Illuminate\Database\Eloquent\Model $model Eloquent model
     * @param string $dateType ['day', 'week', 'month', 'year']
     * @return array
     */
    private function totalResultsBy(string $model, $dateType, string $dateField = 'created_at')
    {
        return $model::whereBetween($dateField, [$this->startDate, $this->endDate])
            ->select([
                DB::raw(strtoupper($dateType) . '(created_at) as ' . $dateType),
                DB::raw('COUNT(*) as total')
            ])
            ->groupBy($dateType)
            ->orderBy($dateType, 'DESC')
            ->pluck($dateType, 'total')
            ->flip()
            ->toArray();
    }
}
