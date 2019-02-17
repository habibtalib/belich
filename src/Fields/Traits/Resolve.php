<?php

namespace Daguilarm\Belich\Fields\Traits;

use Illuminate\Support\Collection;

trait Resolve {

    /**
     * Set the field values base on the controller actions
     *
     * @param Illuminate\Support\Collection $fields
     * @param object $sqlResponse
     * @return Illuminate\Support\Collection
     */
    public function setControllerActionForFields(object $fields, object $sqlResponse) : Collection
    {
        //No resolve field by action...
        if($this->action === 'store' || $this->action === 'update' || $this->action === 'destroy') {
            return new Collection;
        }

        //Prepare the field for the index response
        if($this->action === 'index') {
            return $this->setControllerForIndex($fields);

        //Prepare the field for the the form response: create, edit and show
        } else {
            return $this->setController($fields, $sqlResponse);
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

    public function setController(object $fields, object $sqlResponse)
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
}
