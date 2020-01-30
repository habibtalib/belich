<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Field;

class Decimal extends Field
{
    public float $decimals;
    public string $type = 'decimal';

    public function __construct($name = null, $attribute = null)
    {
        parent::__construct($name, $attribute);

        //Cast the field as float
        $this->toFloat();
    }

    /**
     * Set the number of decimals
     */
    public function decimals(int $decimals): self
    {
        $this->decimals = $decimals;

        return $this;
    }

    /**
     * Disabled method
     * Resolving field value in index and detailed
     */
    public function displayUsing(callable $displayCallback): Field
    {
        return $this;
    }

    /**
     * Disabled method
     * Prefix for field value
     */
    public function prefix(string $prefix, bool $space = false): Field
    {
        return $this;
    }

    /**
     * Disabled method
     * Suffix for field value
     */
    public function suffix(string $suffix, bool $space = false): Field
    {
        return $this;
    }
}
