<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Field;
use Daguilarm\Belich\Fields\Traits\Disabled\NoPrefixable;
use Daguilarm\Belich\Fields\Traits\Disabled\NoResolvable;

final class Boolean extends Field
{
    use NoPrefixable,
        NoResolvable;

    public string $color = 'green';
    public string $falseValue;
    public string $trueValue;
    public string $type = 'boolean';
    private array $defaultColors = ['green', 'red', 'blue'];

    /**
     * Create a new field.
     */
    public function __construct($name = null, $attribute = null)
    {
        parent::__construct($name, $attribute);

        //Set the html by default because we are showing icons as value (green or grey)
        $this->asHtml = true;

        //Cast the field as bool
        $this->toBoolean();

        //Not resolve or display field
        $this->notResolveField();
    }

    /**
     * Set the boolean color
     */
    public function color(string $color): self
    {
        $this->color = in_array($color, $this->defaultColors) ? $color : 'green';

        return $this;
    }

    /**
     * Set the label for false
     */
    public function falseValue(string $value): self
    {
        $this->falseValue = $value;

        return $this;
    }

    /**
     * Set the label for true
     */
    public function trueValue(string $value): self
    {
        $this->trueValue = $value;

        return $this;
    }

    /**
     * Disabled method
     * Add new css classes to the current field
     */
    public function addClass(...$values): Field
    {
        return $this;
    }

    /**
     * Disabled method
     * Add the autofocus value
     */
    public function autofocus(): Field
    {
        return $this;
    }
}
