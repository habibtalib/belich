<?php

namespace Daguilarm\Belich\Fields\Traits;

trait Attributable
{
    /**
     * @var array
     */
    public $addClass = [];

    /**
     * The attribute / column name of the field
     *
     * @var string
     */
    public $attribute;

    /**
     * @var string
     */
    public $autocomplete;

    /**
     * @var string
     */
    public $autofocus;

    /**
     * @var array
     */
    public $data;

    /**
     * @var bool
     */
    public $disabled = false;

    /**
     * @var string
     */
    public $pattern;

    /**
     * @var string
     */
    public $placeholder;

    /**
     * @var bool
     */
    public $readonly = false;

    /**
     * All the attributes to be removed from $field
     *
     * @var array
     */
    public $removedAttr = [];

    /**
     * Add new css classes to the current field
     *
     * @return self
     */
    public function addClass(...$values): self
    {
        foreach ($values as $value) {
            $this->addClass[] = $value;
        }

        return $this;
    }

    /**
     * Add the autocomplete value: On
     *
     * @return self
     */
    public function autocompleteOn(): self
    {
        $this->autocomplete = 'on';

        return $this;
    }

    /**
     * Add the autocomplete value: Off
     *
     * @return self
     */
    public function autocompleteOff(): self
    {
        $this->autocomplete = 'off';

        return $this;
    }

    /**
     * Add the autofocus value
     *
     * @return self
     */
    public function autofocus(): self
    {
        $this->autofocus = true;

        return $this;
    }

    /**
     * Set data attributes
     *
     * @return self
     */
    public function data($attribute, $value): self
    {
        $this->data[] = [$attribute, $value];

        return $this;
    }

    /**
     * Set the attribute with the attribute 'disabled'
     *
     * @param  bool  $value
     *
     * @return self
     */
    public function disabled(bool $value = true): self
    {
        if (isset($value)) {
            $this->disabled = true;
        }

        return $this;
    }

    /**
     * Set the attribute default value
     *
     * @param  string|null  $value
     *
     * @return self
     */
    public function defaultValue($value = null): self
    {
        //Check the value for conditional cases...
        if (isset($value)) {
            $this->value = $value;
        }

        return $this;
    }

    /**
     * Set the attribute pattern
     *
     * @param  string  $value
     *
     * @return self
     */
    public function pattern(string $value): self
    {
        $this->pattern = $value;

        return $this;
    }

    /**
     * Set the attribute placeholder
     *
     * @param  string|null  $value [sometimes we need a empty placeholder for javascript or else... so we can just create an empty one]
     *
     * @return self
     */
    public function placeholder(?string $value = null): self
    {
        $this->placeholder = $value;

        return $this;
    }

    /**
     * Set the field with the attribute 'readonly'
     *
     * @param  bool  $value
     *
     * @return self
     */
    public function readOnly(bool $value = true): self
    {
        if (isset($value)) {
            $this->readonly = true;
        }

        return $this;
    }

    /**
     * Remove attributes from $field
     * Just for internal use
     *
     * @param array $attributes
     *
     * @return self
     */
    protected function removedAttr(array ...$attributes): self
    {
        $this->removedAttr = $attributes;

        return $this;
    }
}
