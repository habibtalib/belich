<?php

use Daguilarm\Belich\Fields\Field;
use Illuminate\Support\Str;

/**
 * Resolve field values: relationship, callbacks, etc...
 *
 * @param  Daguilarm\Belich\Fields\Field $attribute
 * @param  object $data
 * @return string
 */
if (!function_exists('resolveFieldValue')) {
    function resolveFieldValue(Field $field, object $data = null) : string
    {
        //Relationship
        if(is_array($field->attribute) && count($field->attribute) === 2 && !empty($data)) {
            $value = $data->{$field->attribute[0]}->{$field->attribute[1]} ?? emptyResults();
        //Edit value
        } elseif(!empty($data)) {
            $value = $data->{$field->attribute} ?? emptyResults();
        //Show value
        } else {
            $value = $field->value;
        }

        //DisplayUsing
        if(is_callable($field->displayCallback)) {
            $value = call_user_func($field->displayCallback, $value);
        }

        //ResolveUsing
        if(is_callable($field->resolveCallback)) {
            //Add the data for the show view
            if(Belich::action() === 'show') {
                $data = $field->data;
            }

            $value = call_user_func($field->resolveCallback, $data);
        }

        return $value;
    }
}
