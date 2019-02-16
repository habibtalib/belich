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
    function icon(string $icon, string $text = '', $css = '') : string
    {
        // Set right margin if we have text
        $margin = $text ? ' mr-2' : '';

        //Set the css
        $css = $css ? ' ' . $css : ' icon';

        return sprintf('<i class="fas fa-%s%s%s"></i>%s', $icon, $margin, $css, $text);
    }
}

/**
 * Render the action icons
 *
 * @param string $icon
 * @return string
 */
if (!function_exists('actionIcon')) {
    function actionIcon(string $icon) : string
    {
        return sprintf('<i class="fas fa-%s"></i>', $icon);
    }
}

/**
 * Get either a Gravatar URL or complete image tag for a specified email address.
 *
 * @param string $email The email address
 * @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
 * @param string $d Default imageset to use [ 404 | mp | identicon | monsterid | wavatar ]
 * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
 * @source https://gravatar.com/site/implement/images/php/
 */
if (!function_exists('gravatar')) {
    function gravatar($email, $size = 80, $imageSet = 'mp', $rating = 'g') : string
    {
        $email = md5( strtolower( trim( $email ) ) );
        return sprintf('https://www.gravatar.com/avatar/%s?s=%s&d=%s&r=%s', $email, $size, $imageSet, $rating);
    }
}
