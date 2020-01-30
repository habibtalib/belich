<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Traits;

trait Attributable
{
    /**
     * @var string|array
     */
    public $attribute;

    /**
     * Warning!: $data must not be accessed before initialization
     * @var object|null
     */
    public $data;

    public array $removedAttr = [];
    public array $addClass = [];
    public string $autocomplete;
    public bool $autofocus;
    public bool $disabled = false;
    public int $maxlength;
    public string $pattern;
    public string $placeholder;
    public bool $readonly = false;

    /**
     * Add new css classes to the current field
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
     */
    public function autocompleteOn(): self
    {
        $this->autocomplete = 'on';

        return $this;
    }

    /**
     * Add the autocomplete value: Off
     */
    public function autocompleteOff(): self
    {
        $this->autocomplete = 'off';

        return $this;
    }

    /**
     * Add the autofocus value
     */
    public function autofocus(): self
    {
        $this->autofocus = true;

        return $this;
    }

    /**
     * Set data attributes
     */
    public function data($attribute, $value): self
    {
        $this->data[] = [$attribute, $value];

        return $this;
    }

    /**
     * Set the attribute with the attribute 'disabled'
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
     * Set the textArea maximum length
     */
    public function maxlength(int $value): self
    {
        $this->maxlength = $value;

        return $this;
    }

    /**
     * Set the attribute pattern
     */
    public function pattern(string $value): self
    {
        $this->pattern = $value;

        return $this;
    }

    /**
     * Set the attribute placeholder
     */
    public function placeholder(?string $value = null): self
    {
        $this->placeholder = $value;

        return $this;
    }

    /**
     * Set the field with the attribute 'readonly'
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
     */
    protected function removedAttr(array ...$attributes): self
    {
        $this->removedAttr = $attributes;

        return $this;
    }
}
