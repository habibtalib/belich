<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Field;

class Pattern extends Field {

    /** @var string */
    public $type = 'pattern';

    /** @var string */
    public $mask;

    /**
     * Set the field mask
     *
     * @param  string  $mask
     * @return self
     */
    public function mask(string $mask) : self
    {
        $this->mask = $mask;

        return $this;
    }
}
