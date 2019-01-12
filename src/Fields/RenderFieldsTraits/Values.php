<?php

namespace Daguilarm\Belich\Fields\RenderFieldsTraits;

trait Values {

    /**
     * Fill the field value with the model
     *
     * @param object $fields
     * @return object
     */
    private function fillValue($fields)
    {
        return collect($fields)->map(function($field) {
            //Get the attribute value
            $attribute = $field->attribute;

            //Relationship case
            if($this->basePath('Fields\RenderFieldsTrait\Models')->countRelationship($attribute) === 2) {
                $field->value = self::fillValueFromRelationship($attribute);

            //Regular case
            } else {
                $field->value = optional($this->model)->{$field->attribute};
            }

            return $field;
        });
    }

    /**
     * Fill the field value with a model relationship
     *
     * @param string $attribute
     * @return object
     */
    private function fillValueFromRelationship($attribute)
    {
        //Set default values
        $relationship = $this->basePath('Fields\RenderFieldsTrait\Models')
            ->getRelationshipMethod($attribute);

        $relationshipAttribute = $this->basePath('Fields\RenderFieldsTrait\Models')
            ->getRelationshipAttribute($attribute);

        //Verify if the current resource has a relationship defined...
        //Application resource
        $relationshipFromModel = $this->resourceClass->getRelationships();

        if(in_array($relationship, $relationshipFromModel)) {
            $result = optional($this->model)->{$relationship};

            //If more than one results... return the collection with all the results
            if($result->count() > 1) {
                //In the future will create a new field to show all the values...
                return $result;
            }

            //Only one result
            if($result->count() === 1) {
                return $result->first()->{$relationshipAttribute};
            }
        }

        return emptyResults();
    }
}
