<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Field;

class Number extends Field
{
    /** @var int */
    public $max;

    /** @var int */
    public $min;

    /** @var int|float */
    public $step;

    /** @var string */
    public $type = 'number';

    /**
     * Set min value
     *
     * @param int $min
     *
     * @return self
     */
    public function min(int $min): self
    {
        $this->min = $min;

        return $this;
    }

    /**
     * Set max value
     *
     * @param int $max
     *
     * @return self
     */
    public function max(int $max): self
    {
        $this->max = $max;

        return $this;
    }

    /**
     * Set step value
     *
     * @param int $step
     *
     * @return self
     */
    public function step(int $step): self
    {
        $this->step = $step;

        return $this;
    }
}
