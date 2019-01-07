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
if (!function_exists('getResourceName')) {
    function getResourceName() : string
    {
        $getResource = explode('/', request()->route()->uri);

        return stringSingularUpper($getResource[1]);
    }
}

/**
 * Get the resource name
 *
 * @param string $file
 * @return string
 */
if (!function_exists('resourceQueryBuilder')) {
    function resourceQueryBuilder(Illuminate\Http\Request $request)
    {
        $class = sprintf('\\App\\Belich\\Resources\\%s', getResourceName());

        return app($class)->indexQuery($request);
    }
}
