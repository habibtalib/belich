<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Contracts\FieldNumberContract;
use Daguilarm\Belich\Fields\Types\Text;

final class Time extends Text implements FieldNumberContract
{
    /**
     * @var string
     */
    public $type = 'time';

    /**
     * @var string
     */
    public $max;

    /**
     * @var string
     */
    public $min;

    /**
     * @var int|float
     */
    public $step;

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
