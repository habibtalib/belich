<?php

namespace Daguilarm\Belich\Fields\Traits;

trait Casteable
{
    /**
     * @var array
     */
    public $cast;

    /**
     * Cast as string
     *
     * @return self
     */
    public function toBoolean(): self
    {
        $this->cast = 'boolean';

        return $this;
    }

    /**
     * Cast as date
     *
     * @return self
     */
    public function toDate(string $format): self
    {
        $this->cast = 'date:' . $format;

        return $this;
    }

    /**
     * Cast as integer
     *
     * @return self
     */
    public function toInteger(): self
    {
        $this->cast = 'integer';

        return $this;
    }

    /**
     * Cast as float
     *
     * @return self
     */
    public function toFloat(): self
    {
        $this->cast = 'float';

        return $this;
    }

    /**
     * Cast as Hash
     *
     * @return self
     */
    public function toHash(): self
    {
        $this->cast = 'hash';

        return $this;
    }

    /**
     * Cast as json
     *
     * @return self
     */
    public function toJson(): self
    {
        $this->cast = 'json';

        return $this;
    }

    /**
     * Cast as year
     *
     * @return self
     */
    public function toYear(): self
    {
        $this->cast = 'year';

        return $this;
    }

    /**
     * Cast as string
     *
     * @return self
     */
    public function toString(): self
    {
        $this->cast = 'string';

        return $this;
    }
}
