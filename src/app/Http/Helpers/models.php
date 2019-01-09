<?php

/*
|--------------------------------------------------------------------------
| Models
|--------------------------------------------------------------------------
*/

/**
 * Get the value from the $request
 * This helper function is used in the files views/dashboard/create.blade.php and views/dashboard/edit.blade.php
 *
 * @param Illuminate\Http\Request $request
 *
 * @return string
 */
if (!function_exists('getModelFromResource')) {
    function getModelFromResource($resource = null)
    {
        $titleCase = Str::title($resource ?? getResourceName());

        return Str::singular($titleCase);
    }
}
