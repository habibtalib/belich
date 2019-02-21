<?php

namespace Daguilarm\Belich\Components\Metrics\Traits;

trait Eloquentable {

    /**
     * Counts the values for model at the range and previous range
     *
     * @param Illuminate\Http\Request $request
     * @param Illuminate\Database\Eloquent\Model $model Eloquent model
     * @return Matthewnw\Metrics\Classes\Metric
     */
    protected function count($model, $groupColumn, $dateColumn = 'created_at')
    {
        $this->values = DB::table(with(new $model)->getTable())
            ->select("$groupColumn as text", DB::raw('count(*) as value'))
            ->groupBy($groupColumn)->orderBy($groupColumn, 'asc')->get();

        return $this;
    }
}
