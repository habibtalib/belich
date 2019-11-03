<?php

/*
|--------------------------------------------------------------------------
| Resources
|--------------------------------------------------------------------------
*/

/**
 * Get all the resource names from folder
 * For auto route generation
 *
 * @return Illuminate\Support\Collection
 */
if (!function_exists('getAllTheResourcesFromFolder')) {
    function getAllTheResourcesFromFolder(): Illuminate\Support\Collection
    {
        //No file ... install case
        if (!file_exists(app_path('Belich/Resources'))) {
            return new Illuminate\Support\Collection();
        }

        //Get all the files from folder
        $files = scandir(app_path('Belich/Resources'));

        return collect($files)
            ->map(static function ($file) {
                return $file;
            })->filter(static function ($value, $key) {
                return $value !== '.' && $value !== '..';
            })->map(static function ($file) {
                $getFile = getFileAttributes($file);
                return stringPluralLower($getFile);
            });
    }
}

/*
|--------------------------------------------------------------------------
| Get a string with the resource name or ID, base on sprintf()
|--------------------------------------------------------------------------
*/

/**
 * Set the container ID base on the resource
 *
 * @param string $fileName
 * @param bool $extension
 *
 * @return string
 */
if (!function_exists('parseTextWithResource')) {
    //Example of use: parseTextWithResource('form-%s-create', 'name') => form-resourceName-create
    function parseTextWithResource(string $text, $resourceType = 'name'): string
    {
        $type = $resourceType === 'name'
            ? Belich::resource()
            : Belich::resourceId();

        return sprintf($text, $type);
    }
}
