<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Components\Metrics\Traits;

trait Javascriptable
{
    public array $labels;
    public array $series;
    public string $type;
    public string $uriKey;
    public bool $withArea;

    /**
     * Set the labels
     */
    public function labels(array $labels = []): self
    {
        $this->labels = $labels;

        return $this;
    }

    /**
     * Set the serie
     */
    public function series(array $series = []): self
    {
        $this->series = $series;

        return $this;
    }

    /**
     * Set the type
     */
    public function type(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Set the uriKey
     */
    public function uriKey(string $uriKey): self
    {
        $this->uriKey = $uriKey;

        return $this;
    }

    /**
     * Set the withArea
     */
    public function withArea(bool $withArea): self
    {
        $this->withArea = $withArea;

        return $this;
    }
}
