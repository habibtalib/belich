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

/*
|--------------------------------------------------------------------------
| Routes
|--------------------------------------------------------------------------
*/
    /**
     * Get all the resource names from folder
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
