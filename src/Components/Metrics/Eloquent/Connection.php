<?php

namespace Daguilarm\Belich\Components\Metrics\Eloquent;

use Carbon\Carbon;
use Daguilarm\Belich\Components\Metrics\Eloquent\Traits\Cacheable;
use Daguilarm\Belich\Components\Metrics\Eloquent\Traits\DatesForHumans;
use Daguilarm\Belich\Components\Metrics\Eloquent\Traits\Results;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Connection {

    use Cacheable, DatesForHumans, Results;

    /** @var string */
    private $model;

    /** @var object */
    public $startDate;

    /** @var object */
    public $endDate;

    /** @var int */
    public $take;

    /** @var string */
    private $dateTable = 'created_at';

    /**
     * Initialize the class
     *
     * @param string $model
     */
    public function __construct(string $model)
    {
        $this->model = $model;
    }

    /**
     * Set the end date
     *
     * @param string $date
     * @return string
     */
    public function endDate(Carbon $date) : self
    {
        $this->endDate = $date;

        return $this;
    }

    /**
     * Set the start date
     *
     * @param string $date
     * @return string
     */
    public function startDate(Carbon $date) : self
    {
        $this->startDate = $date;

        return $this;
    }

    /**
     * Set a different table name for dates.
     * By default 'create_at'
     *
     * @param string $date
     * @return string
     */
    public function dateTable($tableName) : self
    {
        $this->dateTable = $tableName;

        return $this;
    }

    /**
     * Get only a number of results from storage
     *
     * @param string $take
     * @return string
     */
    public function take(int $take) : self
    {
        $this->take = $take;

        return $this;
    }

    /**
     * Initialize the connection
     */
    public static function make($model)
    {
        return new Connection($model);
    }

    /**
     * Get the results by type and dateType from storage
     *
     * @param string $dateType ['day', 'month', 'year']
     * @param string $type ['average', 'total', 'trent']
     * @return Collection
     */
    private function getDataFromStorage(string $dateType, string $type) : Collection
    {
        return $this->model::whereBetween($this->dateTable, [$this->startDate, $this->endDate])
            ->select([
                DB::raw(strtoupper($dateType) . '(' . $this->dateTable . ') as ' . $dateType),
                DB::raw('COUNT(*) as total'),
            ])
            ->groupBy($dateType)
            ->orderBy($dateType, 'DESC')
            ->when(is_numeric($this->take), function($query) {
                return $query->take($this->take);
            })
            ->get();
    }

    /**
     * Get the total results filter by date and reset the value to 0 if no results
     *
     * @param array $totals
     * @param string $dateType ['day', 'month', 'year']
     * @param string $type ['average', 'total', 'trent']
     * @return array
     */
    private function resultsByDate(array $total, string $dateType, string $type) : array
    {
        //Set the total days, months or years and reset to 0
        $total = array_fill_keys($total, 0);

        //Get the data from cache or storage
        $sql = ($this->cache instanceof Carbon)
            ? $this->getDataFromCache($dateType, $type)
            : $this->getDataFromStorage($dateType, $type);

        return collect($total)
            ->map(function($value, $date) use($sql, $dateType) {
                //Search the days with results
                return $sql->where($dateType, $date)->first()->total ?? 0;
            })
            ->toArray();
    }
}
