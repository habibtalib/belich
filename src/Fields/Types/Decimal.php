<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Field;
use Daguilarm\Belich\Fields\Traits\Disabled\NoDisplayable;
use Daguilarm\Belich\Fields\Traits\Disabled\NoPrefixable;

class Decimal extends Field
{
    use NoDisplayable,
        NoPrefixable;

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
}
