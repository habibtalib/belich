<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Contracts\FieldNumberContract;
use Daguilarm\Belich\Fields\Types\Text;

final class Time extends Text implements FieldNumberContract
{
    /**
     * @var int|float
     */
    public $step;

    /**
     * @var string|int
     */
    public $max;

    /**
     * @var string|int
     */
    public $min;

    public string $type = 'time';

    /**
     * Set min value
     *
     * @param string|int $min
     */
    public function min($min): self
    {
        $this->min = (int) $min;

        return $this;
    }

    /**
     * Set max value
     *
     * @param string|int $min
     */
    public function max($max): self
    {
        $this->max = (int) $max;

        return $this;
    }

    /**
     * Set step value
     */
    public function step($step): self
    {
        $this->step = $step;

        return $this;
    }
}
