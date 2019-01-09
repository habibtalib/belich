<?php

/*
|--------------------------------------------------------------------------
| Objects
|--------------------------------------------------------------------------
*/

/**
 * Get the value from the $request and the $field
 * This helper function is used in the file views/dashboard/show.blade.php
 *
 * @param Illuminate\Http\Request $request
 * @param Daguilarm\Belich\Fields\Field $field
 * @return string
 */
if (!function_exists('getValueForDetailed')) {
    function getValueForDetailed($request, $field) : string
    {
        $attribute = optional($field)->attribute;
        $data = optional($request['data']);

        //Data from the storage
        if(!empty($data) && !is_null($attribute)) {
            $result = optional($data)->{$attribute};
        //Data from form
        } else {
            $result = optional($field)->value;
        }

        return !empty($result)
            ? $result
            : emptyResults();
    }
}

/**
 * Get the value from the $request
 * This helper function is used in the files views/dashboard/create.blade.php and views/dashboard/edit.blade.php
 *
 * @param Illuminate\Http\Request $request
 *
 * @return string
 */
if (!function_exists('getValueForForm')) {
    function getValueForForm($request, $data = null)
    {
        //Create case
        if($request->action === 'create') {
            return $request->value;

        //Edit case
        } else {
            //Set the attribute
            $attribute = optional($request)->attribute;

            //Check for relationship
            $relationship = explode('.', $attribute);
            if(count($relationship) === 2) {

                //Get the relationship parameters
                $primaryKey = optional($data)->getKeyName();
                $relationship = optional($data)->{$relationship[0]};

                //Return the relationship
                if($primaryKey && $relationship) {
                    return optional($relationship)->first()->{$primaryKey};
                }

                return null;
            }

            return optional($data)->{$attribute};
        }
    }
}
