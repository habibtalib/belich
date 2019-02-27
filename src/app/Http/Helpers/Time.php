<?php

use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Dates and Time
|--------------------------------------------------------------------------
*/

/**
 * Set time for cookies
 *
 * @return int
 */
if (!function_exists('setTimeForCookie')) {
    function setTimeForCookie() : int
    {
        return Carbon::now()->addYear()->timestamp;
    }
}
