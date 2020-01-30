<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Field;

final class Header extends Field
{
    public string $type = 'header';
    public string $background = 'gray-300';
    public string $color = 'gray-600';

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
     */
    public function asHtml(): Field
    {
        $this->asHtml = true;

        return $this;
    }

    /**
     * Set the background
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
     */
    public function color(?string $color): self
    {
        if ($color) {
            $this->color = $color;
        }

        return $this;
    }
}
