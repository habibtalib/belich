<?php

namespace Daguilarm\Belich\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RestfullController extends Controller
{
    /**
     * List the resources for administration.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data         = getResourceQueryBuilder($request);
        $resource     = getResource();
        $resourceName = getResourceName();

        return $data;
    }

    /**
     * Show.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return;
    }

    /**
     * Store.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return;
    }

    /**
     * Update.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return;
    }

    /**
     * Delete.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $id)
    {
        return;
    }
}
