<?php

namespace Daguilarm\Belich\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Daguilarm\Belich\Fields\ResolveFields as Fields;
use Daguilarm\Belich\Fields\ValidateFields as Validate;
use Illuminate\Http\Request;

class RestfullController extends Controller
{
    /**
     * List the resources.
     *
     * @param Illuminate\Http\Request $request
     * @param Daguilarm\Belich\Fields\ResolveFields $fields
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
     * @param Daguilarm\Belich\Fields\ResolveFields $fields
     * @param Daguilarm\Belich\Fields\ValidateFields $validate
     * @return \Illuminate\Http\Response
     */
    public function create(Fields $fields, Validate $validate)
    {
        //Load the view with the data
        return view('belich::dashboard.create')
            ->withRequest($fields->handle())
            ->withSettings($fields->settings())
            ->withJavascript($validate->make());
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
     * @param Daguilarm\Belich\Fields\ResolveFields $fields
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
     * @param Daguilarm\Belich\Fields\ResolveFields $fields
     * @param Daguilarm\Belich\Fields\ValidateFields $validate
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Fields $fields, Validate $validate, $id)
    {
        //Load the view with the data
        return view('belich::dashboard.edit')
            ->withRequest($fields->handle())
            ->withSettings($fields->settings())
            ->withJavascript($validate->make());
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
