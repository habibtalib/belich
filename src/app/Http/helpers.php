<?php

/*
|--------------------------------------------------------------------------
| Files
|--------------------------------------------------------------------------
*/

/**
 * Get the name from a file string [file.ext]
 *
 * @param string $file
 * @param int $position
 * @return string
 */
if (!function_exists('getFileName')) {
    function getFileName($file, $position = 0) : string
    {
        $str = explode('.', $file);

        return !empty($str) ? $str[$position] : '';
    }
}

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
                return stringPluralLower(getFileName($file));
            });
    }
}

/**
 * Return the route base path: dashboard or else...
 *
 * @return string
 */
if (!function_exists('basePath')) {
    function basePath() : string
    {
        return str_replace('/', '', config('belich.path'));
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

/*
|--------------------------------------------------------------------------
| icons
|--------------------------------------------------------------------------
*/

/**
 * Render the icons
 *
 * @return string
 */
if (!function_exists('icon')) {
    function icon(string $icon, $text = null) : string
    {
        $icon = sprintf('<i class="fas fa-%s"></i>', $icon);

        return $text
            ? $icon . ' ' . $text
            : $icon;
    }
}
