<?php

namespace Daguilarm\Belich\App\Http\Controllers;

use Daguilarm\Belich\App\Http\Controllers\BaseController;
use Daguilarm\Belich\Core\Belich;
use Daguilarm\Belich\Fields\FieldValidate as Validate;
use Illuminate\Http\Request;

class RestfullController extends BaseController
{
    /**
     * Generate crud controllers
     *
     * @param Daguilarm\Belich\Core\Belich $belich
     */
    public function __construct(Belich $belich)
    {
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
    public function index(Belich $belich, Request $request)
    {
        //Get all the data
        $data = $this->getAllData($belich, $request);

        //Load the view with the data
        return view('belich::dashboard.index')
            ->withActions($data->get('actions'))
            ->withBreadcrumbs($data->get('breadcrumbs'))
            ->withFields($data->get('fields'))
            ->withResults($data->get('results'))
            ->withTotalResults($data->get('total'));
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
        if($this->model::create($request->all())) {
            return redirect()
                ->back()
                ->withSuccess('Hellow');
        }

        return redirect()
            ->back()
            ->withErrors(['Errors']);
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
            ->withBreadcrumbs($this->breadcrumbs)
            ->withFields($this->fields)
            ->withResource($this->name)
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
