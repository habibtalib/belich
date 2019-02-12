<?php

use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Utils
|--------------------------------------------------------------------------
*/

/**
 * Get all the resource names from folder
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
 * Get all the resource names from folder
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
 * Render the icons
 *
 * @param string $icon
 * @param string $text
 * @return string
 */
if (!function_exists('icon')) {
    function icon(string $icon, string $text = '') : string
    {
        // Set right margin if we have text
        $margin = $text ? ' mr-2' : '';

        $icon = sprintf('<i class="fas fa-%s%s"></i>', $icon, $margin);

        return $text
            ? $icon . $text
            : $icon;
    }
}
