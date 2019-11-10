<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Field;

final class Header extends Field
{
    /**
     * @var string
     */
    public $type = 'header';

    /**
     * @var string
     */
    public $color;

    /**
     * Create a new field.
     *
     * @param  string|null  $name
     * @param  string|null  $attribute
     *
     * @return  void
     */
    public function __construct($name = null)
    {
        parent::__construct($name, null);

        $this->onlyOnForms();
    }

    /**
     * Resolve the value as HTML (without scape)
     *
     * @return \Daguilarm\Belich\Fields\FieldBase
     */
    public function asHtml(): \Daguilarm\Belich\Fields\FieldBase
    {
        $this->asHtml = true;

        return $this;
    }

    /**
     * Set the color
     *
     * @param  string $color
     *
     * @return  self
     */
    public function color(string $color): self
    {
        $this->color = $color;

        return $this;
    }
}
