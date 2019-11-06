<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Field;

final class Pattern extends Field
{
    /**
     * @var string
     */
    public $type = 'pattern';

    /**
     * @var string
     */
    public $mask;

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

        //Cast the field as string
        $this->toString();
    }

    /**
     * Set the field mask
     *
     * @param  string  $mask
     *
     * @return self
     */
    public function mask(string $mask): self
    {
        $this->mask = $mask;

        return $this;
    }
}
