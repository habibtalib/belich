<?php

use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Paths
|--------------------------------------------------------------------------
*/

/**
 * Get the package namespace path
 *
 * @param string $file
 * @return string
 */
if (!function_exists('namespace_path')) {
    function namespace_path($file) : string
    {
        return '\\Daguilarm\\Belich\\' . $file;
    }
}

/**
 * Get the resource path
 *
 * @param string $file
 * @return string
 */
if (!function_exists('route_path')) {
    function route_path($file) : string
    {
        return sprintf('%s/%s', config('belich.path'), $file);
    }
}

/**
 * Built belich urls
 *
 * @return string
 */
if (!function_exists('belich_path')) {
    function belich_path($resource = null) : string
    {
        return sprintf('%s%s/%s', config('belich.url'), config('belich.path'), $resource);
    }
}

/*
|--------------------------------------------------------------------------
| Routes
|--------------------------------------------------------------------------
*/

/**
 * Get all the resource names from folder
 * For auto route generation
 *
 * @return Illuminate\Support\Collection
 */
if (!function_exists('getAllTheResourcesFromFolder')) {
    function getAllTheResourcesFromFolder() : Illuminate\Support\Collection
    {
        //Get all the files from folder
        $files = scandir(app_path('Belich/Resources'));

        return collect($files)
            ->map(function($file) {
                return $file;
            })->filter(function($value, $key) {
                return $value !== '.' && $value !== '..';
            })->map(function($file) {
                return stringPluralLower(Utils::getFileAttributes($file));
            });
    }
}

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
