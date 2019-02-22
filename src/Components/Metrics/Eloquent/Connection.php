<?php

namespace Daguilarm\Belich\Components\Metrics\Eloquent;

use Daguilarm\Belich\Components\Metrics\Eloquent\Traits\Total;

class Connection {

    use Dateable, Total;

    /** @var object */
    private $model;

    /** @var object */
    private $query;

    /** @var object */
    private $dateStart;

    /** @var object */
    private $dateEnd;

    /** @var string */
    private $dateTable = 'created_at';

    /**
     * Set the connection model
     *
     * @param string $model
     * @return string
     */
    public function model(string $model) : self
    {
        $this->model = $model;

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
     * Get the model response
     *
     * @return array
     */
    public function get() : array
    {
        return $query->toArray();
    }
}
