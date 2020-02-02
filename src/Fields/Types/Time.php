<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Types\Text;

final class Time extends Text
{
    /**
     * @var int|float
     */
    public $step;

    public string $max;
    public string $min;
    public string $type = 'time';

    /**
     * Set min value
     */
    public function min(string $min): self
    {
        $this->min = (string) $min;

        return $this;
    }

    /**
     * Set max value
     */
    public function max(string $max): self
    {
        $this->max = (string) $max;

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
