<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Components\Helpers;

use Daguilarm\Belich\Facades\Helper;
use Illuminate\Support\Facades\Cookie;

trait Forms
{
    private array $attributeFilter = [
        'addClass' => 'class',
    ];

    /**
     * Helper for the blade directive @optionFromArray
     * Set the default value for a empty string or result
     */
    public function createFormSelectOptions(array $options, string $field, bool $emptyField = false): string
    {
        $cache = Cookie::get('belich_' . $field);

        return collect($options)
            ->map(static function ($label, $value) use ($cache) {
                // Set label
                $label = is_string($label) ? strtolower($label) : $label;
                // Default values
                $defaultValue = ! is_array($value) ? $label : $value;
                // Strict types
                $value = (string) $value;
                $defaultValue = (string) $defaultValue;

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
     * Resolve select field using labels
     * This method is helper for $this->resolve()
     *
     * @param string|int|float|null $value
     *
     * @return string|int|float|null
     */
    public function displayUsingLabels(object $field, $value)
    {
        return $field->options[$value] ?? $field->value ?? null;
    }

    /**
     * Render the field attribute base on the value
     * Helper for the belich fields: ./resources/fields
     */
    public function formAttribute(object $field, string $attribute, ?string $default = null, ?string $prefix = null): string
    {
        //Get the attribute
        $attribute = $this->getAttribute($attribute);

        //Get the value
        $value = $this->getValue($field, $attribute, $default);

        //Render a specific list of attributes: boolean, mask, country input...
        $renderFromArray = $this->renderAttributeFromArray($field, $attribute, $value);

        //Render the default attributes: dusk, id, name,...
        $render = $this->renderAttribute($attribute, $value, $prefix);

        //Render value for Country field
        $this->renderCountry($field);

        return $renderFromArray ?? $render;
    }

    /**
     * Get the attribute name
     */
    private function getAttribute(string $attribute): string
    {
        //Apply the html format. Ex: Change the attribute addClass to class (for html render)...
        return str_replace(
            array_keys($this->attributeFilter),
            array_values($this->attributeFilter),
            $attribute
        );
    }

    /**
     * Get the attribute name
     *
     * @return  string|object|null
     */
    private function getValue(object $field, string $attribute, ?string $default = null)
    {
        return isset($field->addClass) && is_array($field->addClass) && $attribute === 'class'
            // Css class attribute
            ? collect($field->addClass)->push($default)->filter()->join(' ')
            // Regular attribute
            : $default ?? $field->{$attribute} ?? null;
    }

    /**
     * Render attributes from an array of tasks
     *
     * @param mixed $value
     */
    private function renderAttributeFromArray(object $field, string $attribute, $value): ?string
    {
        $response = [
            'mask' => sprintf('data-mask="%s"', $value),
            'checked' => $field->value ? 'checked="checked"' : '',
        ];

        return in_array($attribute, array_keys($response))
            ? $response[$attribute]
            : null;
    }

    /**
     * Render the attribute
     *
     * @param string|object $value
     */
    private function renderAttribute(string $attribute, $value, ?string $prefix): string
    {
        return $value
            ? sprintf('%s%s="%s"', $prefix, $attribute, $value)
            : '';
    }

    /**
     * Render the list of countries
     */
    private function renderCountry(object $field): void
    {
        //Value for countries
        if (Helper::objectName($field) === 'Countries') {
            // Get the countries
            $countries = trans('belich::metrics.countriesOfTheWorldWithCodes');
            // Set the value
            collect($countries)
                ->each(static function ($country) use ($field): void {
                    if ($field->value === $country['code']) {
                        $field->inputValue = $country['name'];
                    }
                })->filter();
        }
    }

    /**
     * Helper for determine a selected option
     */
    private static function selectedValueForOption(?string $cache, string $value, ?string $defaultValue): string
    {
        return $cache === $defaultValue || $cache === $value
            ? ' selected'
            : '';
    }
}
