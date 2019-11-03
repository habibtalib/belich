<?php

/*
|--------------------------------------------------------------------------
| Helpers for softdeleting
|--------------------------------------------------------------------------
*/

/**
 * Set if the model has the trait softdelete
 *
 * @return bool
 */
if (!function_exists('hasSoftdelete')) {
    function hasSoftdelete($model): bool
    {
        if (method_exists($model, 'trashed')) {
            return true;
        }

        return false;
    }
}

/**
 * Set if the model has softdeleting results
 *
 * @return bool
 */
if (!function_exists('hasSoftdeletedResults')) {
    function hasSoftdeletedResults($model): bool
    {
        if (method_exists($model, 'trashed') && $model->trashed()) {
            return true;
        }

        return false;
    }
}

/*
|--------------------------------------------------------------------------
| Working with forms
|--------------------------------------------------------------------------
*/

/**
 * Convert a field string (coma separated values) into an array
 * Only works on numeric
 * This is for using mass selection and $model->whereIn($array)
 *
 * @return array
 */
if (!function_exists('fieldToArray')) {
    function fieldToArray($values): array
    {
        $listOfValues = explode(',', $values);

        return collect($listOfValues)
            ->map(static function ($value) {
                // Only numeric values
                if (!empty($value) && is_numeric($value)) {
                    return (integer) $value;
                }
            })
            ->filter()
            ->toArray();
    }
}
