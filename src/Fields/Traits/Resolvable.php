<?php

namespace Daguilarm\Belich\Fields\Traits;

use Illuminate\Support\Collection;

trait Resolvable {

    /*
    |--------------------------------------------------------------------------
    | Controller actions
    |--------------------------------------------------------------------------
    */

    /**
     * Set the field values base on the controller actions
     *
     * @param Illuminate\Support\Collection $fields
     * @param object $sqlResponse
     * @return Illuminate\Support\Collection
     */
    public function setControllerActionForFields(object $fields, object $sqlResponse) : Collection
    {
        //No resolve field for not visual actions
        if($this->action === 'store' || $this->action === 'update' || $this->action === 'destroy') {
            return new Collection;
        }

        //Prepare the field for the index response
        if($this->action === 'index') {
            // return app(\Daguilarm\Belich\Fields\FieldResolveIndex::class)->make($fields, $sqlResponse);
            return $this->setControllerForIndex($fields);

        //Prepare the field for the the form response: create, edit and show
        } else {
            return $this->setCrudController($fields, $sqlResponse);
        }

        return $fields;
    }

    /**
     * Set the values base on the index controller action
     *
     * @param Illuminate\Support\Collection $fields
     * @return Illuminate\Support\Collection
     */
    private function setControllerForIndex(Collection $fields) : Collection
    {
        return $fields->map(function($field) {
            //Showing field relationship in index
            //See blade template: dashboard.index
            $field->attribute = $field->fieldRelationship
                //Prepare field for relationship
                ? [$field->fieldRelationship, $field->attribute]
                //No relationship field
                : $field->attribute;

            return $field;
        });
    }

    /**
     * Set the values base on the controllers action (except for index)
     *
     * @param Illuminate\Support\Collection $fields
     * @param object $sqlResponse
     * @return Illuminate\Support\Collection
     */
    public function setCrudController(object $fields, object $sqlResponse)
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
    | Visibility
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
    | Attributes
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
