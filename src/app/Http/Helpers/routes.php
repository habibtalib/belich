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
 * Get the route action: index, edit, update...
 *
 * @return Illuminate\Http\Request
 */
if (!function_exists('getRouteAction')) {
    function getRouteAction() : string
    {
        //Get route name
        $routeName = explode('.', request()->route()->getName());

        //Return last item from the array
        return end($routeName);
    }
}

/**
 * Get the resource: users
 *
 * @return Illuminate\Http\Request
 */
if (!function_exists('getResourceName')) {
    function getResourceName() : string
    {
        $resource = explode('/', request()->route()->uri);

        return $resource[1];
    }
}

/**
 * Get the resource name: User
 *
 * @return Illuminate\Http\Request
 */
if (!function_exists('getResourceClass')) {
    function getResourceClass() : string
    {
        return title_case(str_singular(getResourceName()));
    }
}

/**
 * Get the route id
 *
 * @return Illuminate\Http\Request
 */
if (!function_exists('getRouteId')) {
    function getRouteId($resource = null)
    {
        $parameter = str_singular($resource ?? getResourceName());

        return request()->route($parameter) ?? null;
    }
}

/**
 * Return the route base path: dashboard or else...
 *
 * @return string
 */
if (!function_exists('getRouteBasePath')) {
    function getRouteBasePath() : string
    {
        return str_replace('/', '', config('belich.path'));
    }
}

/**
 * Return the route for the form action
 *
 * @return string
 */
if (!function_exists('getRouteForm')) {
    function getRouteForm($resource, $action) : string
    {
        return sprintf('%s.%s.%s', getRouteBasePath(), $resource, $action);
    }
}
