<?php

/*
|--------------------------------------------------------------------------
| Objects
|--------------------------------------------------------------------------
*/

/**
 * Get all the resource names from folder
 *
 * @return string
 */
if (!function_exists('getValueFromData')) {
    function getValueFromData($request, $field) : string
    {
        $attribute = optional($field)->attribute;
        $data = optional($request['data']);
        $result = $data->{$attribute};

        return !empty($result)
            ? $result
            : emptyResults();
    }
}
