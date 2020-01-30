<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Types\Number;

final class Range extends Number
{
    public string $type = 'range';
    public array $options = [];

    /**
     * Add option values to the select
     */
    public function options(array $options = []): self
    {
        //Check the text for conditional cases...
        if (isset($options)) {
            $this->options = $options;
        }

        return $this;
    }
}
