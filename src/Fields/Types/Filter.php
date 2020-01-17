<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Types\Select;

class Filter extends Select
{
    /**
     * @var string
     */
    public $filter;

    /**
     * @var string
     */
    public $format = 'm/d/Y';

    /**
     * @var string
     */
    public $mask = '00/00/0000';

    /**
     * Set the search filter type
     *
     * @param string $value
     *
     * @return self
     */
    public function filterAs(string $value): self
    {
        $this->filter = $value;

        return $this;
    }

    /**
     * Set the date format
     *
     * @param string $value
     *
     * @return self
     */
    public function format(string $value): self
    {
        $this->format = $value;

        return $this;
    }

    /**
     * Set the date mask
     *
     * @param string $value
     *
     * @return self
     */
    public function mask(string $value): self
    {
        $this->mask = $value;

        return $this;
    }
}
