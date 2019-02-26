<?php

/*
|--------------------------------------------------------------------------
| Messages
|--------------------------------------------------------------------------
*/

/**
 * Get the message session
 *
 * @return int
 */
if (!function_exists('messages')) {
    function messages(string $type) : array
    {
        return $type === 'errors'
            ? session()->get($type)->all()
            : session()->get($type);
    }
}
