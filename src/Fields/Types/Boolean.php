<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Field;

final class Boolean extends Field
{
    /**
     * @var string
     */
    public $color = 'green';

    /**
     * @var string
     */
    public $falseValue;

    /**
     * @var string
     */
    public $trueValue;

    /**
     * @var string
     */
    public $type = 'boolean';

    /**
     * @var array
     */
    private $defaultColors = ['green', 'red', 'blue'];

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

        //Set the html by default because we are showing icons as value (green or grey)
        $this->asHtml = true;

        //Cast the field as bool
        $this->toBoolean();

        //Not resolve or display field
        $this->notResolveField();
    }

    /**
     * Set the boolean color
     *
     * @param  string  $color
     *
     * @return self
     */
    public function color(string $color): self
    {
        $this->color = in_array($color, $this->defaultColors) ? $color : 'green';

        return $this;
    }

    /**
     * Set the label for false
     *
     * @param  string  $value
     *
     * @return self
     */
    public function falseValue(string $value): self
    {
        $this->falseValue = $value;

        return $this;
    }

    /**
     * Set the label for true
     *
     * @param  string  $value
     *
     * @return self
     */
    public function trueValue(string $value): self
    {
        $this->trueValue = $value;

        return $this;
    }

    /**
     * Disabled field
     * Add new css classes to the current field
     *
     * @return Daguilarm\Belich\Fields\Field
     */
    public function addClass(...$values): Field
    {
        return $this;
    }

    /**
     * Disabled field
     * Add the autofocus value
     *
     * @return Daguilarm\Belich\Fields\Field
     */
    public function autofocus(): Field
    {
        return $this;
    }

    /**
     * Disabled field
     * Resolving field value in index and detailed
     *
     * @param  object  $displayCallback
     *
     * @return Daguilarm\Belich\Fields\Field
     */
    public function displayUsing(callable $displayCallback): Field
    {
        return $this;
    }

    /**
     * Disabled field
     * Prefix for field value
     *
     * @param  string  $prefix
     * @param  bool  $space
     *
     * @return Daguilarm\Belich\Fields\Field
     */
    public function prefix(string $prefix, bool $space = false): Field
    {
        return $this;
    }

    /**
     * Disabled field
     * Resolving field value (before processing) in all the fields
     *
     * @param  object  $resolveCallback
     *
     * @return Daguilarm\Belich\Fields\Field
     */
    public function resolveUsing(callable $resolveCallback): Field
    {
        return $this;
    }

    /**
     * Disabled field
     * Suffix for field value
     *
     * @param  string  $suffix
     * @param  bool  $space
     *
     * @return Daguilarm\Belich\Fields\Field
     */
    public function suffix(string $suffix, bool $space = false): Field
    {
        return $this;
    }
}
