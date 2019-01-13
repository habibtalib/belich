<?php

namespace Daguilarm\Belich\Fields;

use Daguilarm\Belich\Contracts\Handler;
use Daguilarm\Belich\Fields\ResolveFieldsAbstract;
use Illuminate\Http\Request;

class ResolveFields extends ResolveFieldsAbstract implements Handler {

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
        $this->action        = getRouteAction();
        $this->resource      = getResourceClass();
        $this->resourceClass = app(sprintf('\\App\\Belich\\Resources\\%s', $this->resource));
        $this->routeId       = getRouteId();

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
        $fields = parent::getFields();

        return parent::action($fields);
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
