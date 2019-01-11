<?php

namespace Daguilarm\Belich\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Daguilarm\Belich\Fields\FieldsConstructor as Fields;
use Daguilarm\Belich\Validations\Validation;
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
        return view('belich::dashboard.index')
            ->withRequest($fields->handle())
            ->withSettings($fields->settings());
    }

    /**
     * Create a new resource.
     *
     * @param Daguilarm\Belich\Fields\FieldsConstructor $fields
     * @return \Illuminate\Http\Response
     */
    public function create(Fields $fields, Validation $validation)
    {
        //Load the view with the data
        return view('belich::dashboard.create')
            ->withRequest($fields->handle())
            ->withSettings($fields->settings())
            ->withJavascript($validation->make());
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
     * @param Daguilarm\Belich\Fields\FieldsConstructor $fields
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Fields $fields, $id)
    {
        //Load the view with the data
        return view('belich::dashboard.show')
            ->withRequest($fields->handle())
            ->withSettings($fields->settings());
    }

    /**
     * Edit a resource.
     *
     * @param Daguilarm\Belich\Fields\FieldsConstructor $fields
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Fields $fields, Validation $validation, $id)
    {
        //Load the view with the data
        return view('belich::dashboard.edit')
            ->withRequest($fields->handle())
            ->withSettings($fields->settings())
            ->withJavascript($validation->make());
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
