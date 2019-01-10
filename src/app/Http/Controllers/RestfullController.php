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
     * @param Illuminate\Http\Request $request
     * @param Daguilarm\Belich\Fields\FieldsConstructor $fields
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Fields $fields, Validation $validation)
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
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'locale' => 'required'
        ]);
        $validator->setAttributeNames([
            'name' => 'nombre'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        } else {
            return response()->json(['success']);
        }
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
        return view('belich::dashboard.show')
            ->withRequest($fields->handle())
            ->withSettings($fields->settings());
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
        return view('belich::dashboard.edit')
            ->withRequest($fields->handle())
            ->withSettings($fields->settings());
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
        return view('belich::dashboard.update')
            ->withRequest($fields->handle())
            ->withSettings($fields->settings());
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
