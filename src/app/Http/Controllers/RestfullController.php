<?php

namespace Daguilarm\Belich\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Daguilarm\Belich\Constructor\Belich;
use Illuminate\Http\Request;

class RestfullController extends Controller
{
    /**
     * List the resources.
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Get all the data
        //The default action is the function name (__FUNCTION__)
        return view('belich::dashboard.index')->withRequest(Belich::updateRequest($request, __FUNCTION__));
    }

    /**
     * Create a new resource.
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //Get all the data
        //The default action is the function name (__FUNCTION__)
        return view('belich::dashboard.create')->withRequest(Belich::updateRequest($request, __FUNCTION__));
    }

    /**
     * Show.
     *
     * @param Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        //Get all the data
        //The default action is the function name (__FUNCTION__)
        return view('belich::dashboard.show')->withRequest(Belich::updateRequest($request, __FUNCTION__, $id));
    }

    /**
     * Store.
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return;
    }

    /**
     * Update.
     *
     * @param Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return;
    }

    /**
     * Delete.
     *
     * @param Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $id)
    {
        return;
    }
}
