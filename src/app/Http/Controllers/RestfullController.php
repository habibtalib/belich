<?php

namespace Daguilarm\Belich\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Daguilarm\Belich\Core\Belich;
use Daguilarm\Belich\Facades\Utils;
use Daguilarm\Belich\Fields\FieldValidate as Validate;
use Illuminate\Http\Request;

class RestfullController extends Controller
{
    /** @var array */
    private $breadcrumbs;

    /** @var array */
    private $fields;

    /** @var string */
    private $name;

    /** @var Illuminate\Support\Collection */
    private $resource;

    /**
     * Generate crud controllers
     *
     * @param Daguilarm\Belich\Core\Belich $belich
     */
    public function __construct(Belich $belich)
    {
        //Get the current resource values
        $this->resource    = $belich->currentResource();

        $this->breadcrumbs = $this->resource->get('values')->get('breadcrumbs');
        $this->fields      = $this->resource->get('fields');
        $this->name        = $this->resource->get('name');

        //Share the setting to all the views
        view()->share([
            'resources' => $belich->resourcesAll(),
        ]);
    }

    /**
     * List the resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Load the view with the data
        return view('belich::dashboard.index')
            ->withBreadcrumbs($this->breadcrumbs)
            ->withFields($this->fields)
            ->withResults($this->resource->get('results'))
            ->withTotalResults(Utils::count($this->fields, 2));
    }

    /**
     * Create a new resource.
     *
     * @param Daguilarm\Belich\Fields\FieldValidate $validate
     * @return \Illuminate\Http\Response
     */
    public function create(Validate $validate)
    {
        //Load the view with the data
        return view('belich::dashboard.create')
            ->withBreadcrumbs($this->breadcrumbs)
            ->withFields($this->fields)
            ->withJavascript($validate->create($this->resource))
            ->withResource($this->name);
    }

    /**
     * Store a new resource.
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return 'stored!';
    }

    /**
     * Show the a resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Load the view with the data
        return view('belich::dashboard.show')
            ->withResource($this->resource)
            ->withResourceId($id);
    }

    /**
     * Edit a resource.
     *
     * @param Daguilarm\Belich\Fields\ValidateFields $validate
     * @param int $id
     */
    public function edit(Validate $validate, $id)
    {
        //Load the view with the data
        return view('belich::dashboard.edit')
            ->withBreadcrumbs($this->breadcrumbs)
            ->withFields($this->fields)
            ->withJavascript($validate->create($this->resource))
            ->withResource($this->name)
            ->withResourceId($id);
    }

    /**
     * Update a resource.
     *
     * @param Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Update the storage...
        return;
    }

    /**
     * Delete a resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        return;
    }
}
