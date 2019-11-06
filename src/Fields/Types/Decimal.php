<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Field;

abstract class Decimal extends Field
{
    /**
     * @var int|float
     */
    public $decimals;

    /**
     * @var string
     */
    public $type = 'decimal';

    /**
     * Create a new field.
     *
     * @param  string|null  $name
     * @param  string|null  $attribute
     */
    public function __construct($name = null, $attribute = null)
    {
        parent::__construct($name, $attribute);

        //Cast the field as float
        $this->toFloat();
    }

    /**
     * Set the number of decimals
     *
     * @param int $decimals
     *
     * @return self
     */
    public function decimals(int $decimals): self
    {
        $this->decimals = $decimals;

        return $this;
    }
}
