<?php

/*
|--------------------------------------------------------------------------
| Helper for set if a model has softdeleting
|--------------------------------------------------------------------------
*/

/**
 * Set the default value for a empty string or result
 *
 * @return string
 */
if (!function_exists('isTrashed')) {
    function isTrashed($model)
    {
        if(method_exists($model, 'trashed')) {
            return true;
        }

        return false;
    }
}
