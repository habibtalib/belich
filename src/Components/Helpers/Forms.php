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
    private function setFormAttribute(Field $field, string $attribute, ?string $default = null): string
    {
        //Render css classes
        $field = $this->addClassAttribute($field, $attribute);

        //Add classes
        $value = isset($field->{$attribute}) && $attribute === 'addClass' && isset($default)
            ? $field->{$attribute} . ', ' . $default
            : $field->{$attribute} ?? $default;

        //Apply the html format. Ex: Change the attribute addClass to class (for html render)...
        $attribute = str_replace(array_keys($this->attributeFilter), array_values($this->attributeFilter), $attribute);

        //Pattern mask
        if ($attribute === 'mask') {
            return sprintf('data-mask="%s"', $value);
        }

        //Checked field
        if ($attribute === 'checked') {
            return $field->value ? 'checked="checked"' : '';
        }

        return $value
            ? sprintf('%s="%s"', $attribute, $value)
            : '';
    }

    /**
     * Render the class attribute
     *
     * @param Daguilarm\Belich\Fields\Field $field
     * @param string $attribute
     *
     * @return Daguilarm\Belich\Fields\Field
     */
    private function addClassAttribute($field, $attribute): Field
    {
        //Render css classes
        $field->addClass = $attribute === 'addClass' && isset($field->addClass)
            ? implode(' ', $field->addClass)
            : '';

        return $field;
    }

    /**
     * Render the field attribute base on the value with a prefix
     * This fields is mostly for Coordenate fields
     *
     * @param Daguilarm\Belich\Fields\Field $field
     * @param string $prefix
     *
     * @return string
     */
    private function renderWithPrefix(Field $field, string $prefix): string
    {
        return collect(explode(' ', $field->render))->map(static function ($item) use ($prefix) {
            //Get the fields
            $item = explode('=', $item);

            return count($item) > 1
                //Prefixed regular fields
                ? [$item[0] => implode('_', [$prefix, $item[1]])]
                //Prefixed dusk field
                : $this->renderWithPrefixForDuskAndReadonlyAndDisabled($item, $prefix);
        })
            ->map(static function ($value) {
                return is_array($value)
                    ? sprintf('%s=%s', array_keys($value)[0], array_values($value)[0])
                    : $value;
            })
            ->implode(' ');
    }

    /**
     * Helper for renderWithPrefix()
     * This fields is mostly for Coordenate fields
     *
     * @param Daguilarm\Belich\Fields\Field $field
     * @param string $prefix
     *
     * @return string
     */
    private function renderWithPrefixForDuskAndReadonlyAndDisabled($item, $prefix)
    {
        $value = explode('-', $item[1]);

        //Format: dusk-$prefix-$attribute
        array_splice($value, 1, 0, $prefix);

        return $item[0] === 'dusk'
            ? [$item[0] => implode('-', $value)]
            //Fields: readonly and disabled (this fields don't has an structure like: attribute=value)
            : $item[0];
    }
}
