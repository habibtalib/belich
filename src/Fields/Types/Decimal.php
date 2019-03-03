<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Field;

class Decimal extends Field {

    /** @var int|float */
    public $decimals;

    /** @var string */
    public $type = 'decimal';

    /**
     * Set the number of decimals
     *
     * @param int $decimals
     * @return self
     */
    public function decimals(int $decimals) : self
    {
        $this->decimals = $decimals;

        return $this;
    }
}
