<?php

/*
|--------------------------------------------------------------------------
| Helper for the blade directive @optionFromArray
|--------------------------------------------------------------------------
*/

/**
 * Set the default value for a empty string or result
 *
 * @return string
 */
if (!function_exists('createFormSelectOptions')) {
    function createFormSelectOptions($options, $field)
    {
        return collect($options)
            ->map(function($key, $value) use ($field) {
                //Default values
                $selected = Cookie::get('belich_' . $field) == $value ? ' selected' : '';
                $value = ($value === 0) ? $key : $value;
                $selected = (Cookie::get('belich_' . $field) == $value) ? ' ' . 'selected' : '';

                return sprintf('<option value="%s"%s>%s</option>', $value, $selected, $key);
            })
            ->implode('');
    }
}
