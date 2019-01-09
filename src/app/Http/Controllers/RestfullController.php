<?php

namespace Daguilarm\Belich\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Daguilarm\Belich\Fields\FieldsConstructor as Fields;
use Illuminate\Http\Request;

class RestfullController extends Controller
{
    /**
     * List the resources.
     *
     * @param Illuminate\Http\Request $request
     * @param Daguilarm\Belich\Fields\FieldsConstructor $fields
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Fields $fields)
    {
        //Load the view with the data
        return view('belich::dashboard.index')->withRequest($fields->handle());
    }

    /**
     * Create a new resource.
     *
     * @param Illuminate\Http\Request $request
     * @param Daguilarm\Belich\Fields\FieldsConstructor $fields
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Fields $fields)
    {
        //Load the view with the data
        return view('belich::dashboard.create')->withRequest($fields->handle());
    }

    /**
     * Store a new resource.
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return;
    }

    /**
     * Show the a resource.
     *
     * @param Illuminate\Http\Request $request
     * @param Daguilarm\Belich\Fields\FieldsConstructor $fields
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Fields $fields, $id)
    {
        //Load the view with the data
        return view('belich::dashboard.show')->withRequest($fields->handle());
    }

    /**
     * Edit a resource.
     *
     * @param Illuminate\Http\Request $request
     * @param Daguilarm\Belich\Fields\FieldsConstructor $fields
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Fields $fields, $id)
    {
        //Load the view with the data
        return view('belich::dashboard.edit')->withRequest($fields->handle());
    }

    /**
     * Update a resource.
     *
     * @param Illuminate\Http\Request $request
     * @param Daguilarm\Belich\Fields\FieldsConstructor $fields
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fields $fields, $id)
    {
        //Load the view with the data
        return view('belich::dashboard.update')->withRequest($fields->handle());
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
