<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Traits;

trait Casteable
{
    public string $cast;

    /**
     * Cast as string
     */
    public function toBoolean(): self
    {
        $this->cast = 'boolean';

        return $this;
    }

    /**
     * Cast as date
     */
    public function toDate(string $value): self
    {
        $this->cast = 'date:' . $value;

        return $this;
    }

    /**
     * Cast as integer
     */
    public function toInteger(): self
    {
        $this->cast = 'integer';

        return $this;
    }

    /**
     * Cast as float
     */
    public function toFloat(): self
    {
        $this->cast = 'float';

        return $this;
    }

    /**
     * Cast as Hash
     */
    public function toHash(): self
    {
        $this->cast = 'hash';

        return $this;
    }

    /**
     * Cast as html
     */
    public function toHtml(): self
    {
        $this->cast = 'html';

        return $this;
    }

    /**
     * Cast as json
     */
    public function toJson(): self
    {
        $this->cast = 'json';

        return $this;
    }

    /**
     * Cast as year
     */
    public function toYear(): self
    {
        $this->cast = 'year';

        return $this;
    }

    /**
     * Cast as string
     */
    public function toString(): self
    {
        $this->cast = 'string';

        return $this;
    }
}
