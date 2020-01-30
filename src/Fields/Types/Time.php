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

    public string $type = 'time';
    public int $max;
    public int $min;

    /**
     * Set min value
     */
    public function min(string $min): self
    {
        $this->min = $min;

        return $this;
    }

    /**
     * Set max value
     */
    public function max(string $max): self
    {
        $this->max = $max;

        return $this;
    }

    /**
     * Set step value
     */
    public function step(string $step): self
    {
        $this->step = $step;

        return $this;
    }
}
