<?php

use Daguilarm\Belich\Fields\Field;
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
 * Get the resource path
 *
 * @param object $data
 * @return string
 */
// if (!function_exists('route_show')) {
//     function route_show($data) : string
//     {
//         //return route(sprintf('%s.%s'));
//     }
// }

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

/**
 * Resolve field values: relationship, callbacks, etc...
 *
 * @param  Daguilarm\Belich\Fields\Field $attribute
 * @param  object $data
 * @return string
 */
if (!function_exists('resolveFieldValue')) {
    function resolveFieldValue(Field $field, object $data = null) : string
    {
        //Relationship
        if(is_array($field->attribute) && count($field->attribute) === 2 && !empty($data)) {
            $value = $data->{$field->attribute[0]}->{$field->attribute[1]} ?? emptyResults();
        //Edit value
        } elseif(!empty($data)) {
            $value = $data->{$field->attribute} ?? emptyResults();
        //Show value
        } else {
            $value = $field->value;
        }

        //DisplayUsing
        if(is_callable($field->displayCallback)) {
            $value = call_user_func($field->displayCallback, $value);
        }

        //ResolveUsing
        if(is_callable($field->resolveCallback)) {
            //Add the data for the show view
            if(Belich::action() === 'show') {
                $data = $field->data;
            }

            $value = call_user_func($field->resolveCallback, $data);
        }

        return $value;
    }
}
