<?php

/*
|--------------------------------------------------------------------------
| Models
|--------------------------------------------------------------------------
*/

/**
 * Get the value from the $request
 * This helper function is used in the files views/dashboard/index.blade.php
 *
 * @param Illuminate\Http\Request $request
 *
 * @param object $field
 * @param string|array $attribute
 * @return string
 */
if (!function_exists('evalue')) {
    function evalue(object $item, $attribute) : string
    {
        //Relationship
        if(is_array($attribute) && count($attribute) === 2) {
            return $item->{$attribute[0]}->{$attribute[1]} ?? emptyResults();
        }

        //Regular value
        return $item->{$attribute} ?? emptyResults();
    }
}

/**
 * Get the value from the $request
 * This helper function is used in the files views/dashboard/index.blade.php
 *
 * @param Illuminate\Http\Request $request
 *
 * @param object|array $items
 * @return int
 */
if (!function_exists('countResults')) {
    function countResults($items) : int
    {
        if(is_array($items)) {
            return count($items);
        }

        if(is_object($items)) {
            return $items->count();
        }

        return 0;
    }
}
