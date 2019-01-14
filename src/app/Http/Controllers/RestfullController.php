<?php

namespace Daguilarm\Belich\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Daguilarm\Belich\Belich;
use Daguilarm\Belich\Fields\FieldValidate as Validate;
use Illuminate\Http\Request;

class RestfullController extends Controller
{
    /**
     * List the resources.
     *
     * @param Illuminate\Http\Request $request
     * @param Daguilarm\Belich\Belich $fields
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Belich $belich)
    {
        //Load the view with the data
        return view('belich::dashboard.index')->withRequest($belich->create());
    }

    /**
     * Create a new resource.
     *
     * @param Daguilarm\Belich\Belich $belich
     * @param Daguilarm\Belich\Fields\FieldValidate $validate
     * @return \Illuminate\Http\Response
     */
    public function create(Belich $belich, Validate $validate)
    {
        //Set the resource values
        $resource = $belich->create();

        //Load the view with the data
        return view('belich::dashboard.create')
            ->withRequest($resource)
            ->withJavascript($validate->create($resource));
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
        return view('belich::dashboard.show')->withRequest($belich->create());
    }

    /**
     * Edit a resource.
     *
     * @param Daguilarm\Belich\Belich $belich
     * @param Daguilarm\Belich\Fields\ValidateFields $validate
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Belich $belich, Validate $validate, $id)
    {
        //Set the resource values
        $resource = $belich->create();

        //Load the view with the data
        return view('belich::dashboard.edit')
            ->withRequest($belich->create())
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
