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
 * Set string into kebab case
 *
 * @return string
 */
if (!function_exists('stringTokebab')) {
    function stringTokebab($string) : string
    {
        return Str::kebab($string);
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
