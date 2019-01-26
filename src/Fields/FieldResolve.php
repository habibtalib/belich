<?php

namespace Daguilarm\Belich\Fields;

use Daguilarm\Belich\Belich;
use Daguilarm\Belich\Fields\Field;
use Illuminate\Support\Collection;

class FieldResolve {

    /**
     * Show or Hide field base on actions
     *
     * @param object $class
     * @param string $controllerAction
     * @param object $fields
     * @return Illuminate\Support\Collection
     */
    public static function make(object $class, string $controllerAction, object $fields, $sqlResponse) : Collection
    {
        //Show or hide fields base on Resource settings
        $fields = static::setVisibilities($fields, $controllerAction);

        //Index action: Return only the name and the attribute for each field.
        if($controllerAction === 'index') {
            return static::setIndexValues($fields);
        }

        //Form actions: Create or Edit
        if($controllerAction === 'create' || $controllerAction === 'edit') {
            // Creating all the render attributes for the forms
            $fields = static::setAttributes($fields);
        }

        //Add values to fields: Only in Edit or Show actions
        if($controllerAction === 'edit' || $controllerAction === 'show') {
            //Fill the field value with the model
            return self::setValues($sqlResponse, $fields);
        }

        return $fields;
    }

    /*
    |--------------------------------------------------------------------------
    | Private methods
    |--------------------------------------------------------------------------
    */

    /**
     * Show or Hide field base on the controller action
     *
     * @param Illuminate\Support\Collection $fields
     * @param string $controllerAction
     * @return array|null
     */
    private static function setVisibilities(Collection $fields, string $controllerAction) : Collection
    {
        return $fields->map(function($field) use ($controllerAction) {
            return $field->visibility[$controllerAction]
                ? $field
                : null;
        })
        ->filter();
    }

    /**
     * Set the values base on the index controller action
     *
     * @param Illuminate\Support\Collection $fields
     * @return Illuminate\Support\Collection
     */
    private static function setIndexValues(Collection $fields) : Collection
    {
        $results = $fields->mapWithKeys(function($field, $key) {
            //Showing field relationship in index
            //See blade template: dashboard.index
            $attribute = $field->fieldRelationship
                ? [$field->fieldRelationship, $field->attribute]
                : $field->attribute;

            return [$field->label => $attribute];
        });

        return collect([
            'attributes' => $results->values()->toArray(),
            'labels'     => $results->keys()->toArray(),
        ]);
    }

    /**
     * Generate the attributes for the fields
     *
     * @param Illuminate\Support\Collection $fields
     * @return \Illuminate\Support\Collection
     */
    private static function setAttributes(Collection $fields) : Collection
    {
        //Set attributes for each field
        return $fields->map(function($field) {

            //Add attributes dynamically from the list
            $field->render = collect($field)
                ->map(function($value, $attribute) use ($field) {
                    if(in_array($attribute, $field->renderAttributes)) {
                        return sprintf('%s=%s', $attribute, $value);
                    }
                })
                ->filter(function($value) {
                    return $value;
                });

            //Add the data attributes
            if($field->data) {
                $data = collect($field->data)
                    ->map(function($value) {
                        return sprintf('data-%s=%s', $value[0], $value[1]);
                    })
                    ->implode(' ');

                $field->render->push($data);
            }

            //Add readonly attribute
            if($field->readonly) {
                $field->render->push('readonly');
            }

            //Add disabled attribute
            if($field->disabled) {
                $field->render->push('disabled');
            }

            //To string...
            $field->render = $field->render->implode(' ');

            return $field;
        });
    }

    /**
     * When the action is update or show
     * We have to update the field value
     *
     * @param Illuminate\Support\Collection $sqlResponse
     * @return Illuminate\Support\Collection
     */
    private static function setValues(object $sqlResponse, Collection $fields) : Collection
    {
        return $fields->map(function($field) use ($sqlResponse) {
            //Set new value for the fields, even if has a fieldRelationship value
            //This relationship method is only on forms
            //Index has its own way in blade template
            $field->value = self::setValuesWithFieldRelationship($sqlResponse, $field);

            return $field;
        });
    }

    /**
     * Determine value with relationship if exists...
     *
     * @param Illuminate\Support\Collection $sqlResponse
     * @param Illuminate\Support\Collection $fields
     * @return Illuminate\Support\Collection
     */
    private static function setValuesWithFieldRelationship(object $sqlResponse, object $field)
    {
        if($field->fieldRelationship) {
            return $sqlResponse->{$field->fieldRelationship}->{$field->attribute} ?? null;
        }

        return $sqlResponse->{$field->attribute} ?? null;
    }
}
