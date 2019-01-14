<?php

namespace Daguilarm\Belich;

use Daguilarm\Belich\Fields\FieldResolve;
use Illuminate\Http\Request;

class Belich {

    private $controllerAction;
    private $resourceClass;
    private $request;
    private $resource;

    public function __construct()
    {
        $this->resourceClass    = app(sprintf('\\App\\Belich\\Resources\\%s', getResourceClass()));
        $this->request          = request();
        $this->controllerAction = getRouteAction();
        $this->resource         = getResourceName();
    }

    public function create()
    {
        return collect([
            // Configuration //
            'availableForNavigation' => $this->resourceClass::$availableForNavigation,
            'controllerAction'       => $this->controllerAction,
            'model'                  => $this->resourceClass::$model,
            'relationships'          => $this->resourceClass::$relationships,
            'resource'               => $this->resource,
            'softDeletes'            => $this->resourceClass::$softDeletes,
            'sqlResponse'            => self::sqlResponse(),

            // Operations //
            'actions'                => $this->resourceClass::$actions,
            'breadcrumb'             => $this->resourceClass::$breadcrumb,
            'cards'                  => $this->resourceClass::$cards,
            'metrics'                => $this->resourceClass::$metrics,

            // Fields //
            'fields'                 => $this->resolveFields(),
        ]);
    }

    private function sqlResponse()
    {
        if($this->controllerAction === 'index') {
            return $this->resourceClass->indexQuery($this->request);
        }

        if($this->controllerAction === 'edit' || $this->controllerAction === 'show') {
            return $this->resourceClass->model()->findOrFail(getRouteId());
        }

        return null;
    }

    private function resolveFields()
    {
        $fields = $this->resourceClass->fields($this->request);

        return (new FieldResolve(collect($fields), $this->controllerAction))->make();
    }
}
