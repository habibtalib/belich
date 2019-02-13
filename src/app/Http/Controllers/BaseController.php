<?php

namespace Daguilarm\Belich\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Daguilarm\Belich\Core\Belich;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    /**
     * List the resource values.
     *
     * @param Daguilarm\Belich\Core\Belich $belich
     * @param Illuminate\Http\Request $request
     * @return array
     */
    public function getAllData(Belich $belich, Request $request)
    {
        //Set current resource
        $data   = $belich->currentResource($request);
        $fields = data_get($data, 'fields');

        return collect([
            'actions'     => data_get($data, 'values.actions'),
            'breadcrumbs' => data_get($data, 'values.breadcrumbs'),
            'fields'      => $fields,
            'name'        => data_get($data, 'name'),
            'results'     => data_get($data, 'results'),
            'total'       => Belich::count($fields, 2),
        ]);
    }

    /**
     * List some resource values.
     *
     * @param Daguilarm\Belich\Core\Belich $belich
     * @param Illuminate\Http\Request $request
     * @return array
     */
    public function getPartialData(Belich $belich, Request $request)
    {
        //Set current resource
        $data = $belich->currentResource($request);

        return collect([
            'breadcrumbs' => data_get($data, 'values.breadcrumbs'),
            'fields'      => data_get($data, 'fields'),
            'name'        => data_get($data, 'name'),
            'validate'    => $data,
        ]);
    }
}
