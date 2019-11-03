<?php

namespace Daguilarm\Belich\Fields\Traits;

use Illuminate\Support\Collection;

trait Resolvable
{
    /*
    |--------------------------------------------------------------------------
    | Resolve controllers except index
    |--------------------------------------------------------------------------
    */

    /**
     * Set the values base on the controllers action (except for index)
     *
     * @param Illuminate\Support\Collection $fields
     * @param object $sqlResponse
     * @return Illuminate\Support\Collection
     */
    protected function setCrudController(object $fields, object $sqlResponse)
    {
        //Set fields attributes: Only for create and edit actions
        if($this->action === 'create' || $this->action === 'edit') {
            // Creating all the render attributes for the forms
            $fields = $this->setAttributesForFields($fields);
        }

        //Resolve values for fields: Only for Edit or Show actions
        if($this->action === 'edit' || $this->action === 'show') {
            //Fill the field value with the model
            return $this->setValueForFields($sqlResponse, $fields);
        }

        return $fields;
    }

    /*
    |--------------------------------------------------------------------------
    | Resolve visibility
    |--------------------------------------------------------------------------
    */

    /**
     * Show or Hide field base on the controller action
     *
     * @param Illuminate\Support\Collection $fields
     * @return array|null
     */
    private function setVisibilityForFields(Collection $fields) : Collection
    {
        return $fields->map(function($field) {
            //If the field has the visibility for this controller action on true...
            return $field->visibility[$this->action]
                ? $field
                : null;
        })
            //Delete all null results from the collection
            ->filter();
    }

    /*
    |--------------------------------------------------------------------------
    | Resolve attributes
    |--------------------------------------------------------------------------
    */

    /**
     * Generate the attributes for the fields
     *
     * @param Illuminate\Support\Collection $fields
     * @return \Illuminate\Support\Collection
     */
    private function setAttributesForFields(Collection $fields) : Collection
    {
        //Set attributes for each field
        return $fields->map(function($field) {

            //Add attributes dynamically from the list
            $field->render = $this->setRenderFieldAttributes($field);

            //Add autofocus attribute
            if($field->autofocus) {
                $field->render->push('autofocus');
            }

            //Add the data attributes
            if($field->data) {
                $field->render->push($this->setRenderFieldAttributesData($field));
            }

            //Add readonly attribute
            if($field->readonly) {
                $field->render->push('readonly');
            }

            //Add disabled attribute
            if($field->disabled) {
                $field->render->push('disabled');
            }

            //Render field
            return $this->renderField($field);
        });
    }
}
