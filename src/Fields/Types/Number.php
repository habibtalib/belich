<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Contracts\FieldNumberContract;
use Daguilarm\Belich\Fields\Field;

class Number extends Field implements FieldNumberContract
{
    /**
     * @var int|float
     */
    public $step;

    public int $max;
    public int $min;
    public string $type = 'number';

    /**
     * Set min value
     */
    public function min(int $min): self
    {
        $this->min = $min;

        return $this;
    }

    /**
     * Set max value
     */
    public function max(int $max): self
    {
        $this->max = $max;

        return $this;
    }

    /**
     * Set step value
     *
     * @var int|float
     */
    public function step($step): self
    {
        $this->step = $step;

        return $this;
    }
}
