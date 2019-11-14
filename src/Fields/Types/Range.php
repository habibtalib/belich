<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Types\Number;

final class Range extends Number
{
    /**
     * @var string
     */
    public $type = 'range';

    /**
     * @var array
     */
    public $options;

    /**
     * Add option values to the select
     *
     * @param array $options
     *
     * @return self
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
