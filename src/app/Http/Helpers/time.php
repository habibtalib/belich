<?php

/*
|--------------------------------------------------------------------------
| Utils
|--------------------------------------------------------------------------
*/

/**
 * Set time to one year
 *
 * @return int
 */
if (!function_exists('setTimeToOneYear')) {
    function setTimeToOneYear() : int
    {
        return 60 * 60 * 24 * 365;
    }
}
