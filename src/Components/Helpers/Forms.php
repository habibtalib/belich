<?php

namespace Daguilarm\Belich\Components\Helpers;

use Daguilarm\Belich\Fields\Field;
use Illuminate\Support\Facades\Cookie;

trait Forms
{
    /**
     * @var array
     */
    private $attributeFilter = [
        'addClass' => 'class',
    ];

    /**
     * Helper for the blade directive @optionFromArray
     * Set the default value for a empty string or result
     *
     * @param array $options
     * @param string $field
     * @param bool $emptyField
     *
     * @return string
     */
    private function createFormSelectOptions(array $options, string $field, bool $emptyField = false): string
    {
        $cache = Cookie::get('belich_' . $field);

        return collect($options)
            ->map(static function ($label, $value) use ($cache) {
                //Default values
                $defaultValue = !is_array($value) ? strtolower($label) : $value;

                return sprintf(
                    '<option value="%s"%s>%s</option>',
                    $defaultValue,
                    static::selectedValueForOption($cache, $value, $defaultValue),
                    $label
                );
            })
            ->prepend($emptyField ? '<option></option>' : '')
            ->implode('');
    }

    /**
     * Helper for determine a selected option
     *
     * @param string|null $cache
     * @param string $value
     * @param string|null $defaultValue
     *
     * @return string
     */
    private static function selectedValueForOption(?string $cache, string $value, ?string $defaultValue): string
    {
        return $cache === $defaultValue || $cache === $value
            ? ' selected'
            : '';
    }

    /**
     * Render the field attribute base on the value
     * Helper for the belich fields: ./resources/fields
     *
     * @param Daguilarm\Belich\Fields\Field $field
     * @param string $attribute
     * @param string|null $default
     *
     * @return string
     */
    private function setFormAttribute(Field $field, string $attribute, ?string $default = null, ?string $prefix = null): string
    {
        //Get the attribute
        $attribute = $this->getAttribute($attribute);

        //Get the value
        $value = $this->getValue($field, $attribute, $default);

        //Pattern mask
        if ($attribute === 'mask') {
            return sprintf('data-mask="%s"', $value);
        }

        //Checked field
        if ($attribute === 'checked') {
            return $field->value ? 'checked="checked"' : '';
        }

        return $this->renderAttribute($attribute, $value, $prefix);
    }

    /**
     * Get the attribute name
     *
     * @param string $attribute
     *
     * @return string
     */
    private function getAttribute(string $attribute): string
    {
        //Apply the html format. Ex: Change the attribute addClass to class (for html render)...
        return str_replace(
            array_keys($this->attributeFilter),
            array_values($this->attributeFilter),
            $attribute,
        );
    }

    /**
     * Get the attribute name
     *
     * @param Daguilarm\Belich\Fields\Field $field
     * @param string|null $attribute
     * @param string|null $default
     *
     * @return string
     */
    private function getValue(Field $field, string $attribute, ?string $default = null): ?string
    {
        return (isset($field->addClass) && is_array($field->addClass) && $attribute === 'class')
            // Css class attribute
            ? collect($field->addClass)->push($default)->filter()->join(' ')
            // Regular attribute
            : $default ?? $field->{$attribute} ?? null;
    }

    /**
     * Render the attribute
     *
     * @param string $attribute
     * @param string|null $value
     * @param string|null $prefix
     *
     * @return string
     */
    private function renderAttribute(string $attribute, ?string $value, ?string $prefix): string
    {
        return $value
            ? sprintf('%s%s="%s"', $prefix, $attribute, $value)
            : sprintf('%s%s', $prefix, $attribute);
    }
}
