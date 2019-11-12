<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Types\Pattern;

final class Year extends Pattern
{
    /**
     * @var string
     */
    public $type = 'pattern';

    /**
     * Create a new field.
     *
     * @param  string|null  $name
     * @param  string|null  $attribute
     *
     * @return  void
     */
    public function __construct($name = null, $attribute = null)
    {
        parent::__construct($name, $attribute);

        //Set pattern
        $this->mask('9999');

        //Cast the field as string
        $this->toYear();
    }
}
