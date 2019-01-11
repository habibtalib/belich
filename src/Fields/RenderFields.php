<?php

namespace Daguilarm\Belich\Fields;

use Illuminate\Http\Request;

class RenderFields {

    /**
     * Set the controller action
     *
     * @var string
     */
    protected $action;

    /**
     * List of fields
     *
     * @var object
     */
    protected $fields;

    /**
     * Set the resource model
     *
     * @var Illuminate\Database\Eloquent\Collection
     */
    protected $model;

    /**
     * Resource name
     *
     * @var string
     */
    protected $resource;

    /**
     * Resource class
     *
     * @var string
     */
    protected $resourceClass;

    /**
     * Request
     *
     * @var Illuminate\Http\Request
     */
    protected $request;

    /**
     * URL id parameter
     *
     * @var int
     */
    protected $routeId;

    /**
     * Initialize the constructor
     */
    public function __construct() {
        //Default values
        $this->action = getRouteAction();
        $this->resource = getResourceClass();
        $this->resourceClass = app(sprintf('\\App\\Belich\\Resources\\%s', $this->resource));
        $this->routeId = getRouteId();

        //Request values
        $this->request = request();

        //Set model
        $this->model = $this->setModel();
    }

    /**
     * Handle the resource fields
     *
     * @return object
     */
    public function handle() {
        //Get all the fields from the Class
        $this->fields = $this->resourceClass->fields($this->request);

        //Show or hide fields base on action
        $this->fields = collect($this->fields)->map(function($field) {
            return $field->showOn[$this->action] ? $field : null;
        })->filter();


        //Index case: Return only the name and the attribute for each field.
        if($this->action === 'index') {
            $this->fields = collect($this->fields)
                ->mapWithKeys(function($field, $key) {
                    return [$field->name => $field->attribute];
                })->all();

            return collect([
                'attributes' => array_values($this->fields),
                'data' => $this->model,
                'labels' => array_keys($this->fields),
            ]);
        }

        //Edit and Show case
        if($this->routeId > 0) {
            //Fill the field value with the model
            return $this->fillValue();
        }

        return $this->fields;
    }

    /**
     * Get the resource settings
     *
     * @return array
     */
    public function settings()
    {
        return $this
            ->resourceClass
            ->getSettings()
            ->prepend(getResourceName(), 'resource')
            ->prepend(getResourceClass(), 'resourceClass')
            ->prepend(getRouteAction(), 'action');
    }

    /**
     * Get the fields list by attribute
     *
     * @return array
     */
    public function fieldListByAttribute()
    {
        $fields = $this->resourceClass->fields($this->request);

        return collect($fields)->map(function($field) {
            return $field->attribute;
        })
        ->all();
    }

    /**
     * Set the model object
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    private function setModel()
    {
        if($this->action === 'index') {
            return $this->resourceClass->indexQuery($this->request);
        }

        if($this->action ==='show' || $this->action === 'edit' && $this->routeId > 0) {
            return $this->resourceClass->findOrFail($this->routeId);
        }
    }

    /**
     * Fill the field value with the model
     *
     * @return object
     */
    private function fillValue()
    {
        return collect($this->fields)->map(function($field) {
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
     * Hydrate the field value with the model
     *
     * @return object
     */
    private function fillValueFromRelationship($attribute)
    {
        //Set default values
        $relationship = $this->getRelationshipMethod($attribute);
        $relationshipAttribute = $this->getRelationshipAttribute($attribute);

        //Verify if the current resource has a relationship defined...
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

    /**
     * Get relationship
     *
     * @return string
     */
    private function getRelationship($attribute)
    {
        return explode('.', $attribute);
    }

    /**
     * Get the array count from the relationship
     *
     * @return string
     */
    private function countRelationship($attribute)
    {
        return count($this->getRelationship($attribute));
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
