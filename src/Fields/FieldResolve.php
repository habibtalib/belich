<?php

namespace Daguilarm\Belich\Fields;

use Daguilarm\Belich\Fields\Field;
use Illuminate\Support\Collection;

class FieldResolve {

    private $controllerAction;
    private $fields;
    private $model;

    public function __construct(string $controllerAction, Collection $fields, $model)
    {
        $this->controllerAction = $controllerAction;
        $this->fields           = $fields;
        $this->model            = $model;
    }

    /**
     * Show or Hide field base on actions
     *
     * @param array $fields
     * @param string $controllerAction
     * @return object
     */
    public function make()
    {
        //Show or hide fields base on Resource settings
        $fields = $this->visibility($this->fields);

        //Update the fields values base on the Controller action
        return $this->values($fields);
    }

    /**
     * Show or Hide field base on actions
     *
     * @param array $fields
     * @return array
     */
    public function visibility($fields)
    {
        return $fields->map(function($field) {
            return $field->visibility[$this->controllerAction]
                ? $field
                : null;
        })
        ->filter();
    }

    /**
     * values the fields values base on the Controller action
     *
     * @return object
     */
    public function values($fields) : Collection
    {
        //Index action: Return only the name and the attribute for each field.
        if($this->controllerAction === 'index') {
            return $this->indexValues($fields);
        }

        //Edit action
        //Show action
        if($this->controllerAction === 'edit' || $this->controllerAction === 'show') {
            //Fill the field value with the model
            return $this->formValues($fields);
        }

        return $fields;
    }

    /**
     * Set the values base on the index controller action
     *
     * @return object
     */
    public function indexValues($fields) : Collection
    {
        $results = $fields->mapWithKeys(function($field, $key) {
            return [$field->name => $field->attribute];
        });

        return collect([
            'attributes' => $results->values(),
            'labels'     => $results->keys(),
        ]);
    }

    /**
     * When the action is update or show
     * We hace to update the field value
     *
     * @return string|null
     */
    private function formValues($fields)
    {
        return $fields->map(function($field) {
            //Get the attribute value
            $attribute = $field->attribute;

            //Relationship case
            if($this->countRelationship($attribute) === 2) {
                $field->value = $this->fillValueFromRelationship($attribute);

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
     * @return string|null
     */
    private function fillValueFromRelationship($attribute)
    {
        //Set default values
        $relationship          = $this->getRelationshipMethod($attribute);
        $relationshipAttribute = $this->getRelationshipAttribute($attribute);

        //Not enough attributes
        if(empty($relationship) || empty($relationshipAttribute)) {
            return null;
        }

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

        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | Relationship helpers
    |--------------------------------------------------------------------------
    */

    /**
     * Get relationship
     *
     * @return array
     */
     private function getRelationship($attribute) : array
     {
         return explode('.', $attribute) ?? [];
     }

     /**
     * Get the array count from the relationship
     *
     * @return int
     */
     private function countRelationship($attribute) : int
     {
         return count($this->getRelationship($attribute)) ?? 1;
     }

     /**
     * Get relationship method
     *
     * @return string
     */
     private function getRelationshipMethod($attribute)
     {
         return $this->getRelationship($attribute)[0];
     }

     /**
     * Get relationship attribute
     *
     * @return string
     */
     private function getRelationshipAttribute($attribute)
     {
         return $this->getRelationship($attribute)[1];
     }
}
