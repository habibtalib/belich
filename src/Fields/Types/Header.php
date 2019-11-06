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
    public $background;

    /**
     * @var string
     */
    public $color;

    /**
     * @var string
     */
    public $icon;

    /**
     * @var string
     */
    public $size;

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
    }

    /**
     * Set the background color
     *
     * @param  string $background
     *
     * @return  self
     */
    public function background(string $background): self
    {
        $this->background = $background;

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

    /**
     * Set the icon
     *
     * @param  string $icon
     *
     * @return  self
     */
    public function icon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Set the text size
     *
     * @param  string $size
     *
     * @return  self
     */
    public function size(string $size): self
    {
        $this->size = $size;

        return $this;
    }
}
