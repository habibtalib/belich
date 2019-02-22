<?php

namespace Daguilarm\Belich\Components\Metrics\Eloquent;

use Daguilarm\Belich\Components\Metrics\Eloquent\Traits\DatesForHumans;
use Daguilarm\Belich\Components\Metrics\Eloquent\Traits\Total;

class Connection {

    use DatesForHumans, Total;

    /** @var string */
    private $model;

    /** @var object */
    private $dateStart;

    /** @var object */
    private $dateEnd;

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
    public function dateEnd($date) : self
    {
        $this->dateEnd = $date;

        return $this;
    }

    /**
     * Set the start date
     *
     * @param string $date
     * @return string
     */
    public function dateStart($date) : self
    {
        $this->dateStart = $date;

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
}
