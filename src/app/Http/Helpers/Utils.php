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

        $icon = sprintf('<i class="fas fa-%s%s icon"></i>', $icon, $margin);

        return $text
            ? $icon . $text
            : $icon;
    }
}

if (!function_exists('actionIcon')) {
    function actionIcon(string $icon) : string
    {
        return sprintf('<i class="fas fa-%s"></i>', $icon);
    }
}
