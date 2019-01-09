<?php

namespace Daguilarm\Belich\Fields;

use Illuminate\Http\Request;

class FieldsConstructor {

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
        $fields = $this->resourceClass->fields($this->request);

        //Index case: Return only the name and the attribute for each field.
        if($this->action === 'index') {
            $fields = collect($fields)->mapWithKeys(function($field, $key) {
                return [$field->name => $field->attribute];
            })
            ->all();

            return collect([
                'attributes' => array_values($fields),
                'data' => $this->model,
                'labels' => array_keys($fields),
            ]);
        }

        return $fields;
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
}
