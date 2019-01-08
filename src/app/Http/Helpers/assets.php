<?php

/*
|--------------------------------------------------------------------------
| Assets
|--------------------------------------------------------------------------
*/

/**
 * Get the asset's path for the package
 *
 * @param string $file
 * @return string
 */
if (!function_exists('package_asset')) {
    function package_asset($file) : string
    {
        return asset('vendor/belich/' . $file);
    }
}
