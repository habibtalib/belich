<?php

namespace Daguilarm\Belich\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Daguilarm\Belich\App\Http\Requests\SearchRequest;
use Daguilarm\Belich\Core\Belich;
use Illuminate\Http\RedirectResponse;

final class SearchController extends Controller
{
    /**
     * Validate fields from ajax
     *
     * @param Illuminate\Http\Request $request
     * @param Daguilarm\Belich\Core\Belich $belich
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(SearchRequest $request, Belich $belich): RedirectResponse
    {
        //Get all the data
        $request = $request->data($belich, $request);

        return response()->json(view('belich::dashboard.index.table', compact('request'))->render());
    }
}
