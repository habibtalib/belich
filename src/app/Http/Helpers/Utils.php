<?php

/*
|--------------------------------------------------------------------------
| Helpers for softdeleting
|--------------------------------------------------------------------------
*/

/**
 * Set if the model has the trait softdelete
 *
 * @return string
 */
if (!function_exists('hasSoftdelete')) {
    function hasSoftdelete($model)
    {
        if(method_exists($model, 'trashed')) {
            return true;
        }

        return false;
    }
}

/**
 * Set if the model has softdeleting results
 *
 * @return string
 */
if (!function_exists('hasSoftdeletedResults')) {
    function hasSoftdeletedResults($model)
    {
        if(method_exists($model, 'trashed') && $model->trashed()) {
            return true;
        }

        return false;
    }
}
