<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Types\Select;

class Filter extends Select
{
    public string $filter;
    public string $format = 'm/d/Y';
    public string $mask = '00/00/0000';

    /**
     * Set the search filter type
     */
    public function filterAs(string $value): self
    {
        $this->filter = $value;

        return $this;
    }

    /**
     * Set the date format
     */
    public function format(string $value): self
    {
        $this->format = $value;

        return $this;
    }

    /**
     * Set the date mask
     */
    public function mask(string $value): self
    {
        $this->mask = $value;

        return $this;
    }
}
