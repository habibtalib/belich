<?php

namespace Daguilarm\Belich\Components\Metrics\Eloquent;

use Carbon\Carbon;
use Daguilarm\Belich\Components\Metrics\Eloquent\Traits\CacheForHumans;
use Daguilarm\Belich\Components\Metrics\Eloquent\Traits\Cacheable;
use Daguilarm\Belich\Components\Metrics\Eloquent\Traits\DatesForHumans;
use Daguilarm\Belich\Components\Metrics\Eloquent\Traits\Results;
use Daguilarm\Belich\Components\Metrics\Eloquent\Traits\Sql;

final class Connection
{
    use Cacheable,
        CacheForHumans,
        DatesForHumans,
        Results,
        Sql;

    /**
     * @var Carbon\Carbon
     */
    public $startDate;

    /**
     * @var Carbon\Carbon
     */
    public $endDate;

    /**
     * @var int
     */
    public $take;

    /**
     * @var string
     */
    private $dateTable = 'created_at';

    /**
     * @var string
     */
    private $model;

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
     *
     * @return string
     */
    public function endDate(Carbon $date): self
    {
        $this->endDate = $date;

        return $this;
    }

    /**
     * Set the start date
     *
     * @param string $date
     *
     * @return string
     */
    public function startDate(Carbon $date): self
    {
        $this->startDate = $date;

        return $this;
    }

    /**
     * Set a different table name for dates.
     * By default 'create_at'
     *
     * @param string $date
     *
     * @return string
     */
    public function dateTable(string $tableName): self
    {
        $this->dateTable = $tableName;

        return $this;
    }

    /**
     * Get only a number of results from storage
     *
     * @param int $take
     *
     * @return string
     */
    public function take(int $take): self
    {
        $this->take = $take;

        return $this;
    }

    /**
     * Initialize the connection
     *
     * @param object $model
     *
     * @return  object
     */
    public static function make($model): object
    {
        return new Connection($model);
    }
}
