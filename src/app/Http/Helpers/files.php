<?php

/*
|--------------------------------------------------------------------------
| Files
|--------------------------------------------------------------------------
*/

/**
 * Get the name from a file string [file.ext]
 *
 * @param string $file
 * @param int $position
 * @return string
 */
if (!function_exists('getFileName')) {
    function getFileName($file, $position = 0) : string
    {
        $str = explode('.', $file);

        return !empty($str) ? $str[$position] : '';
    }
}
