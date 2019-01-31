<?php

/*
|--------------------------------------------------------------------------
| Strings
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
        return str_plural(strtolower($string));
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
        return str_singular(ucfirst($string));
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
