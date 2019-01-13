<?php

namespace Daguilarm\Belich\Fields;

use Illuminate\Support\Collection;

abstract class ResolveFieldsAbstract {

    /**
     * Set the resource model
     *
     * @var Illuminate\Database\Eloquent\Collection
     */
    protected $model;

    /*
    |--------------------------------------------------------------------------
    | Group: Render fields
    |--------------------------------------------------------------------------
    */

    /**
     * Generate the field object
     *
     * @return array
     */
    public function getFields() : Collection
    {
        $fields = $this->resourceClass->fields($this->request);

        return self::handleFieldsVisibility($fields);
    }

    /**
     * Show or Hide field base on actions
     *
     * @param object $fields
     * @return array
     */
    public function handleFieldsVisibility($fields)
    {
        return collect($fields)
            ->map(function($field) {
                return $field->showOn[$this->action] ? $field : null;
            })
            ->filter();
    }

    /*
    |--------------------------------------------------------------------------
    | Group: actions
    |--------------------------------------------------------------------------
    */

    /**
     * Generate the fields base on the current controller action
     *
     * @param object $fields
     * @return object
     */
    public function action($fields) : Collection
    {
        //Index action: Return only the name and the attribute for each field.
        if($this->action === 'index') {
            return self::actionIndex($fields);
        }

        //Edit action
        //Show action
        if($this->routeId > 0) {
            //Fill the field value with the model
            return self::fillValue($fields);
        }

        return $fields;
    }

    /**
     * Generate the fields base on the index controller action
     *
     * @param object $fields
     * @return object
     */
    public function actionIndex($fields) : Collection
    {
        $fields = collect($fields)
            ->mapWithKeys(function($field, $key) {
                return [$field->name => $field->attribute];
            });

        return collect([
            'attributes' => $fields->values(),
            'data' => $this->model,
            'labels' => $fields->keys(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Group: Models
    |--------------------------------------------------------------------------
    */

   /**
    * Set the model object
    *
    * @return Illuminate\Database\Eloquent\Collection
    */
   protected function setModel()
   {
       if($this->action === 'index') {
           return $this->resourceClass->indexQuery($this->request);
       }

       if($this->action ==='show' || $this->action === 'edit' && $this->routeId > 0) {
           return $this->resourceClass->findOrFail($this->routeId);
       }
   }

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
       return count(self::getRelationship($attribute)) ?? 1;
    }

    /**
    * Get relationship method
    *
    * @return string
    */
    private function getRelationshipMethod($attribute)
    {
       return self::getRelationship($attribute)[0];
    }

    /**
    * Get relationship attribute
    *
    * @return string
    */
    private function getRelationshipAttribute($attribute)
    {
       return self::getRelationship($attribute)[1];
    }

    /*
    |--------------------------------------------------------------------------
    | Group: Values
    |--------------------------------------------------------------------------
    */

    /**
     * Fill the field value with the model
     *
     * @param object $fields
     * @return string|null
     */
    private function fillValue($fields)
    {
        return collect($fields)->map(function($field) {
            //Get the attribute value
            $attribute = $field->attribute;

            //Relationship case
            if(self::countRelationship($attribute) === 2) {
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
     * @return string|null
     */
    private function fillValueFromRelationship($attribute)
    {
        //Set default values
        $relationship = self::getRelationshipMethod($attribute);
        $relationshipAttribute = self::getRelationshipAttribute($attribute);

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
}
