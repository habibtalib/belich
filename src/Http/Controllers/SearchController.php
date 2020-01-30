<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Http\Controllers;

use App\Http\Controllers\Controller;
use Daguilarm\Belich\Core\Belich;
use Daguilarm\Belich\Http\Requests\SearchRequest;
use Illuminate\Http\JsonResponse;

final class SearchController extends Controller
{
    /**
     * Validate fields from ajax
     */
    public function __invoke(SearchRequest $request, Belich $belich): JsonResponse
    {
        //Get all the data
        $request = $request->data($belich, $request);

        return response()->json(view('belich::dashboard.index.table', compact('request'))->render());
    }
}
