<?php

/*
|--------------------------------------------------------------------------
| Helpers for the blade directive @optionFromArray
|--------------------------------------------------------------------------
*/

/**
 * Get the value from an array
 *
 * @return string
 */
if (!function_exists('getValueFromArray')) {
    function getValueFromArray($value)
    {
        return is_array($value)
            ? array_values($value)[0]
            : $value;
    }
};

/**
 * Get the value key from an array
 *
 * @return string
 */
if (!function_exists('getValueKeyFromArray')) {
    function getValueKeyFromArray($value)
    {
        return is_array($value)
            ? array_keys($value)[0]
            : $value;
    }
};

/**
 * Set if a select option is 'selected' base on a cookie value
 *
 * @return string
 */
if (!function_exists('getSelectedValueFromCookie')) {
    function getSelectedValueFromCookie($field, $value)
    {
        return Cookie::get('belich_' . $field) == $value
            ? ' ' . 'selected'
            : '';
    }
};

/**
 * Set the default value for a empty string or result
 *
 * @return string
 */
if (!function_exists('createFormSelectOptions')) {
    function createFormSelectOptions($options, $field)
    {
        return collect($options)
            ->map(function($option) use($field) {
                //Default values
                $value = getValueFromArray($option);
                $label = getValueKeyFromArray($option);
                $selected = Cookie::get('belich_' . $field) == $value ? ' selected' : '';

                if(is_array($option) && count($option) <= 1) {
                    return sprintf('<option value="%s"%s>%s</option>', $value, $selected, $label);
                }
                return sprintf('<option value="%s"%s>%s</option>', $value, $selected, $value);
            })
            ->implode('');
    }
}
