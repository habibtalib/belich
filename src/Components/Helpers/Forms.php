<?php

namespace Daguilarm\Belich\Components\Helpers;

use Daguilarm\Belich\Facades\Helper;
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
    public function createFormSelectOptions(array $options, string $field, bool $emptyField = false): string
    {
        $cache = Cookie::get('belich_' . $field);

        return collect($options)
            ->map(static function ($label, $value) use ($cache) {
                //Default values
                $defaultValue = ! is_array($value) ? strtolower($label) : $value;

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
     * Render the field attribute base on the value
     * Helper for the belich fields: ./resources/fields
     *
     * @param object $field
     * @param string $attribute
     * @param string|null $default
     *
     * @return string
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
     * @param object $field
     * @param string|null $attribute
     * @param string|null $default
     *
     * @return string|null
     */
    private function getValue(object $field, string $attribute, ?string $default = null): ?string
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
     * @param object $field
     * @param string|null $attribute
     * @param $value
     *
     * @return string|null
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

    /**
     * Get the attribute name
     *
     * @param Daguilarm\Belich\Fields\Field $field
     *
     * @return void
     */
    private function renderCountry($field): void
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
}
