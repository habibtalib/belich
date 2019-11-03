<?php

namespace Daguilarm\Belich\Components\Helpers;

use Daguilarm\Belich\Fields\Field;
use Illuminate\Support\Facades\Cookie;

trait Forms
{
    /**
     * Helper for the blade directive @optionFromArray
     * Set the default value for a empty string or result
     *
     * @return string
     */
    private function createFormSelectOptions($options, $field, $emptyField = false): string
    {
        $cookie = Cookie::get('belich_' . $field);

        return collect($options)
            ->map(static function ($label, $value) use ($cookie, $field) {
                //Default values
                $defaultValue = !is_array($value) ? strtolower($label) : $value;
                $selected = ($cookie == $defaultValue || $cookie == $value)
                    ? ' ' . 'selected'
                    : '';

                return sprintf('<option value="%s"%s>%s</option>', $defaultValue, $selected, $label);
            })
            ->prepend($emptyField ? '<option></option>' : '')
            ->implode('');
    }

    /**
     * Render the field attribute base on the value
     * Helper for the belich fields: ./resources/fields
     *
     * @param Daguilarm\Belich\Fields\Field $field
     * @param string $attribute
     * @param mixed $default
     *
     * @return string
     */
    private function setFormAttribute(Field $field, string $attribute, $default = null): string
    {
        //Render css classes
        if ($attribute === 'addClass') {
            $field->addClass = !empty($field->addClass)
                ? implode(' ', $field->addClass)
                : '';
        }
        //Checked field
        if ($attribute === 'checked') {
            return $field->value ? 'checked="checked"' : '';
        }
        //Apply the format
        $filterAttribute = str_replace(array_keys($this->attributeFilter), array_values($this->attributeFilter), $attribute);
        //Add classes
        if (isset($field->{$attribute}) && $attribute === 'addClass' && isset($default)) {
            $value = $field->{$attribute} . ', ' . $default;
        //Value or default value
        } else {
            $value = $field->{$attribute} ?? $default;
        }
        //Pattern mask
        if ($filterAttribute === 'mask') {
            return sprintf('data-mask="%s"', $value);
        }

        return $value
            ? sprintf('%s="%s"', $filterAttribute, $value)
            : '';
    }

    /**
     * Render the field attribute base on the value
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
            //Prefixed dusk field
            if ($item[0] === 'dusk') {
                $value = explode('-', $item[1]);
                //Format: dusk-$prefix-$attribute
                array_splice($value, 1, 0, $prefix);
                return [$item[0] => implode('-', $value)];
            }
            //Check for regular fields
            if (count($item) > 1) {
                return [$item[0] => implode('_', [$prefix, $item[1]])];
            }
            //Fields: readonly and disabled (this fields don't has an structure like: attribute=value)
            return $item[0];
        })
            ->map(static function ($value) {
                if (is_array($value)) {
                    return sprintf('%s=%s', array_keys($value)[0], array_values($value)[0]);
                }
                return $value;
            })
            ->implode(' ');
    }
}
