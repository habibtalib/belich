<?php

namespace Daguilarm\Belich\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Daguilarm\Belich\Belich;
use Daguilarm\Belich\Fields\FieldValidate as Validate;
use Illuminate\Http\Request;

class RestfullController extends Controller
{
    /** @var Illuminate\Support\Collection */
    private $resource;

    /** @var Illuminate\Support\Collection */
    private $resources;

    /**
     * Generate crud controllers
     *
     * @param Daguilarm\Belich\Belich $belich
     */
    public function __construct()
    {
        //Initialize the packges
        $this->resource = Belich::resource();

        //Share the setting to all the views
        view()->share(['resources' => Belich::resourcesAll()]);
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
            ->withResource($this->resource);
    }

    /**
     * Create a new resource.
     *
     * @param Daguilarm\Belich\Fields\FieldValidate $validate
     * @return \Illuminate\Http\Response
     */
    public function create(Validate $validate)
    {
        //Set the resource values
        $resource = $this->resource;

        //Load the view with the data
        return view('belich::dashboard.create')
            ->withJavascript($validate->create($resource))
            ->withResource($resource);
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
     * @param Daguilarm\Belich\Belich $belich
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Belich $belich, $id)
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
        //Set the resource values
        $resource = $this->resource;

        //Load the view with the data
        return view('belich::dashboard.edit')
            ->withResource($resource)
            ->withJavascript($validate->create($resource))
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
