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
    public $format = 'm-d-Y';

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
}
