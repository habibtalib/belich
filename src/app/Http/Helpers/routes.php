<?php

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
