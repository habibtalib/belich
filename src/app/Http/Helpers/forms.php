<?php

/*
|--------------------------------------------------------------------------
| Form helpers
|--------------------------------------------------------------------------
*/

/**
 * Set the name or attribute for a form field
 *
 * @param object $data
 * @return string
 */
if (!function_exists('setFieldName')) {
    function setFieldName($data) : string
    {
        return $data->attribute ?? $data->name ?? emptyResults();
    }
}
