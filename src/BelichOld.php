<?php

namespace Daguilarm\Belich;

use Daguilarm\Belich\Components\Breadcrumbs;
use Daguilarm\Belich\Fields\FieldResolve;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class BelichOld {

    use Breadcrumbs;

    /** @var string [The controller action name] */
    private $controllerAction;

    /** @var object [The resource class] */
    private $resourceClass;

    /** @var Illuminate\Http\Request */
    private $request;

    /** @var string [The resource name in migration format] */
    private $resource;

    /** @var object [The resource sql response] */
    private $sqlResponse;

    /**
     * Instantiate the belich admin
     *
     * @return void
     */
    public function __construct()
    {
        $this->resourceClass    = app(sprintf('\\App\\Belich\\Resources\\%s', getResourceClass()));
        $this->request          = request();
        $this->controllerAction = getRouteAction();
        $this->resource         = getResourceName();
        $this->sqlResponse      = $this->sqlResponse();
    }

    /**
     * Create the belich admin
     *
     * @return Illuminate\Support\Collection
     */
    public function create() : Collection
    {
        return collect([
            // Configuration //
            'controllerAction'       => $this->controllerAction,
            'model'                  => $this->resourceClass::$model,
            'relationships'          => $this->resourceClass::$relationships,
            'resource'               => $this->resource,
            'settings'               => $this->getSettings(),
            'softDeletes'            => $this->resourceClass::$softDeletes,
            'sqlResponse'            => $this->sqlResponse,

            // Operations //
            'actions'                => $this->resourceClass::$actions,
            'cards'                  => $this->resourceClass::$cards,
            'metrics'                => $this->resourceClass::$metrics,

            // Fields //
            'fields'                 => $this->resolveFields(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Private methods
    |--------------------------------------------------------------------------
    */

    /**
     * Create the belich admin
     *
     * @return object
     */
    private function sqlResponse() : object
    {
        if($this->controllerAction === 'index') {
            return $this->resourceClass->indexQuery($this->request);
        }

        if($this->controllerAction === 'edit' || $this->controllerAction === 'show') {
            return $this->resourceClass->model()->findOrFail(getRouteId());
        }

        return new \Illuminate\Database\Eloquent\Collection;
    }

    /**
     * Resolve the fields
     *
     * @return Illuminate\Support\Collection
     */
    private function resolveFields() : Collection
    {
        $fields  = collect($this->resourceClass->fields($this->request));
        $resolve = new FieldResolve($this->controllerAction, $fields, $this->sqlResponse);

        return $resolve->make();
    }

    /**
     * Generate the resource settings
     *
     * @return Illuminate\Support\Collection
     */
    private function getSettings() : Collection
    {
        //Get the basic setting and capitalize the string values
        $settings = collect($this->resourceClass::$settings)
            ->map(function($item) {
                if(is_string($item)) {
                    return ucfirst($item);
                }
            });

        //Set the displayInNavigation value
        $settings->displayInNavigation = $settings->get('displayInNavigation') ?? true;

        //Set the label value
        $settings->label = $settings->get('label') ?? ucfirst(str_singular(getResourceName()));

        //Set the labels value
        $settings->labels = $settings->get('labels') ?? str_plural($settings['label']);

        //Set the group value
        $settings->group = $settings->get('group') ?? $settings->get('labels');

        //Add the breadcrumbs to the settings
        $settings->breadcrumbs = $this->breadcrumbsCreate($settings);

        return $settings;
    }
}
