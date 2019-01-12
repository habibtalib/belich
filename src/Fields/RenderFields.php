<?php

namespace Daguilarm\Belich\Fields;

use Daguilarm\Belich\Fields\RenderFieldsTraits\Actions;
use Daguilarm\Belich\Fields\RenderFieldsTraits\Methods;
use Daguilarm\Belich\Fields\RenderFieldsTraits\Models;
use Daguilarm\Belich\Fields\RenderFieldsTraits\Values;
use Illuminate\Http\Request;

class RenderFields {

    use Actions, Methods, Models, Values;

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
     * This values is only for determine the trait... has no real value
     *
     * @var int
     */
    protected $trait;

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
        return $this->basePath('Fields\RenderFieldsTrait\Actions')
            ->action(self::getFields());
    }

    /**
     * Get the resource settings and add new values
     *
     * @return array
     */
    public function settings()
    {
        //Application resource
        return $this
            ->resourceClass
            ->getSettings()
            ->prepend(getResourceName(), 'resource')
            ->prepend(getResourceClass(), 'resourceClass')
            ->prepend(getRouteAction(), 'action');
    }
}
