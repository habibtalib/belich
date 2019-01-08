<?php

/*
|--------------------------------------------------------------------------
| Form helpers
|--------------------------------------------------------------------------
*/

/**
 * Get the name or attribute for a form field
 *
 * @param object $data
 * @return string
 */
if (!function_exists('getFieldName')) {
    function getFieldName($data) : string
    {
        return $data->attribute ?? $data->name ?? emptyResults();
    }
}
