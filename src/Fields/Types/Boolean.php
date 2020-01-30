<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Field;

final class Boolean extends Field
{
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

    /**
     * Disabled method
     * Resolving field value in index and detailed
     */
    public function displayUsing(callable $displayCallback): Field
    {
        return $this;
    }

    /**
     * Disabled method
     * Prefix for field value
     */
    public function prefix(string $prefix, bool $space = false): Field
    {
        return $this;
    }

    /**
     * Disabled method
     * Resolving field value (before processing) in all the fields
     */
    public function resolveUsing(callable $resolveCallback): Field
    {
        return $this;
    }

    /**
     * Disabled method
     * Suffix for field value
     */
    public function suffix(string $suffix, bool $space = false): Field
    {
        return $this;
    }
}
