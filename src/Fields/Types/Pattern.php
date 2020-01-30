<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Field;

class Pattern extends Field
{
    public string $type = 'pattern';
    public string $mask;

    public function __construct($name = null, $attribute = null)
    {
        parent::__construct($name, $attribute);

        //Cast the field as string
        $this->toString();
    }

    /**
     * Set the field mask
     */
    public function mask(string $mask): self
    {
        $this->mask = $mask;

        return $this;
    }
}
