<?php

namespace Daguilarm\Belich\Components\Metrics\Eloquent;

use Daguilarm\Belich\Components\Metrics\Eloquent\Traits\DatesForHumans;
use Daguilarm\Belich\Components\Metrics\Eloquent\Traits\Total;

class Connection {

    use DatesForHumans, Total;

    /** @var string */
    private $model;

    /** @var object */
    public $startDate;

    /** @var object */
    public $endDate;

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
    public function endDate($date) : self
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
    public function startDate($date) : self
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
     * Initialize the connection
     */
    public static function make($model)
    {
        return new Connection($model);
    }

    /**
     * Get the total results filter by date and reset the value to 0 if no results
     *
     * @param array $totals
     * @param array $collection
     * @return array
     */
    private function mapFilterByDate(array $total, array $collection) : array
    {
        // Set the total days, months or years and reset to 0
        $total = array_fill_keys($total, 0);

        return collect($total)
            ->map(function($value, $date) use($collection) {
                //Search the days with results
                $search = $collection[$date] ?? 0;
                //Get the values
                return $value > 0 ? $value : $search;
            })
            ->toArray();
    }
}
