<?php

namespace Daguilarm\Belich\Components\Metrics\Traits;

use Illuminate\Support\Collection;

trait Javascriptable {

    /** @var array */
    public $labels;

    /** @var array */
    public $series;

    /** @var string */
    public $type;

    /** @var string */
    public $uriKey;

    /** @var string */
    public $withArea;

    /**
     * Set the labels
     *
     * @param  array  $labels
     * @return self
     */
    public function labels(array $labels = []) : self
    {
        $this->labels = $labels;

        return $this;
    }

    /**
     * Set the serie
     *
     * @param  array  $serie
     * @return self
     */
    public function series(array $series = []) : self
    {
        $this->series = $series;

        return $this;
    }

    /**
     * Set the type
     *
     * @param  string  $type
     * @return self
     */
    public function type(string $type) : self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Set the uriKey
     *
     * @param  string  $uriKey
     * @return self
     */
    public function uriKey(string $uriKey) : self
    {
        $this->uriKey = $uriKey;

        return $this;
    }

    /**
     * Set the withArea
     *
     * @param  bool  $withArea
     * @return self
     */
    public function withArea(bool $withArea) : self
    {
        $this->withArea = $withArea;

        return $this;
    }
}
