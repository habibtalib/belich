<?php

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
 * @param string|null $resource
 * @return string
 */
if (!function_exists('belich_path')) {
    function belich_path($resource = null) : string
    {
        return sprintf('%s%s/%s', config('belich.url'), config('belich.path'), $resource);
    }
}
