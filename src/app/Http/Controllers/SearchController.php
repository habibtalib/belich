<?php

namespace Daguilarm\Belich\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Daguilarm\Belich\App\Http\Requests\SearchRequest;
use Daguilarm\Belich\Core\Belich;

class SearchController extends Controller
{
    /**
     * Validate fields from ajax
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(SearchRequest $request, Belich $belich)
    {
        dd($belich->currentResource($request)->get('results')->all());

        // //Get all the data
        // $request = $request->data($belich, $request);

        // return response()->json($request);
    }
}
