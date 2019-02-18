<?php

use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Utils
|--------------------------------------------------------------------------
*/

/**
 * Set the string into migration format
 *
 * @return string
 */
if (!function_exists('stringPluralLower')) {
    function stringPluralLower($string) : string
    {
        return Str::plural(strtolower($string));
    }
}

/**
 * Set string into class name format
 *
 * @return string
 */
if (!function_exists('stringPluralUpper')) {
    function stringPluralUpper($string) : string
    {
        return Str::plural(ucfirst($string));
    }
}

/**
 * Set string into model format
 *
 * @return string
 */
if (!function_exists('stringSingularUpper')) {
    function stringSingularUpper($string) : string
    {
        return Str::singular(ucfirst($string));
    }
}

/**
 * Set the default value for a empty string or result
 *
 * @return string
 */
if (!function_exists('emptyResults')) {
    function emptyResults() : string
    {
        return '—';
    }
}

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
                $value = is_array($option) ? array_keys($option)[0] : $option;
                $label = is_array($option) ? array_values($option)[0] : $option;
                $selected = (cookie('belich_' . $field) === $value) ? ' selected' : '';

                if(is_array($option) && count($option) <= 1) {
                    return sprintf('<option value="%s"%s>%s</option>', $value, $selected, $label);
                }
                return sprintf('<option value="%s"%s>%s</option>', $value, $selected, $value);
            })
            ->implode('');
    }
}
