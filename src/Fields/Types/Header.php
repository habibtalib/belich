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
    public $background = 'gray-300';

    /**
     * @var string
     */
    public $color = 'gray-600';

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

        // Only visible on forms and show
        $this->forceVisibility('create', 'edit', 'show');

        // But by default, the show view is disabled...
        $this->hideFromShow();

        //Not resolve field
        $this->notResolveField();
    }

    /**
     * Resolve the value as HTML (without scape)
     *
     * @return Daguilarm\Belich\Fields\Field
     */
    public function asHtml(): Field
    {
        $this->asHtml = true;

        return $this;
    }

    /**
     * Set the background
     *
     * @param  string|null $background
     *
     * @return  self
     */
    public function background(?string $background): self
    {
        if ($background) {
            $this->background = $background;
        }

        return $this;
    }

    /**
     * Set the color
     *
     * @param  string|null $color
     *
     * @return  self
     */
    public function color(?string $color): self
    {
        if ($color) {
            $this->color = $color;
        }

        return $this;
    }
}
