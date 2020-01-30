<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Types\Pattern;

final class Year extends Pattern
{
    public function __construct($name = null, $attribute = null)
    {
        parent::__construct($name, $attribute);

        //Set pattern
        $this->mask('9999');

        //Cast the field as string
        $this->toYear();
    }
}
