<?php

namespace Daguilarm\Belich\Fields;

use Illuminate\Http\Request;

class FieldsConstructor {

    protected $action;
    protected $indexData;
    protected $fields;
    protected $model;
    protected $resource;
    protected $resourceClass;
    protected $request;
    protected $routeId;

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
