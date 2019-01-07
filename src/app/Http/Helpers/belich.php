<?php

/*
|--------------------------------------------------------------------------
| Belich helpers
|--------------------------------------------------------------------------
*/

/**
 * Get the resource name
 *
 * @param string $file
 * @return string
 */
if (!function_exists('getResource')) {
    function getResource() : string
    {
        $getResource = explode('/', request()->route()->uri);

        return $getResource[1];
    }
}

/**
 * Get the resource name
 *
 * @param string $file
 * @return string
 */
if (!function_exists('getResourceName')) {
    function getResourceName() : string
    {
        return stringSingularUpper(getResource());
    }
}

/**
 * Get the resource name
 *
 * @param string $file
 * @return string
 */
if (!function_exists('getResourceQueryBuilder')) {
    function getResourceQueryBuilder(Illuminate\Http\Request $request)
    {
        $class = sprintf('\\App\\Belich\\Resources\\%s', getResourceName());

        return app($class)->indexQuery($request);
    }
}
