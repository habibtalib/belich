<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Contracts\FieldNumberContract;
use Daguilarm\Belich\Fields\Field;

class Number extends Field implements FieldNumberContract
{
    /**
     * @var int
     */
    public $max;

    /**
     * @var int
     */
    public $min;

    /**
     * @var int|float
     */
    public $step;

    /**
     * @var string
     */
    public $type = 'number';

    /**
     * Set min value
     *
     * @param string $min
     *
     * @return self
     */
    public function min(string $min): self
    {
        $this->min = $min;

        return $this;
    }

    /**
     * Set max value
     *
     * @param string $max
     *
     * @return self
     */
    public function max(string $max): self
    {
        $this->max = $max;

        return $this;
    }

    /**
     * Set step value
     *
     * @param string $step
     *
     * @return self
     */
    public function step(string $step): self
    {
        $this->step = $step;

        return $this;
    }
}
