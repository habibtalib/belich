<?php

namespace Daguilarm\Belich\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Daguilarm\Belich\Core\Belich;
use Daguilarm\Belich\Fields\FieldValidate as Validate;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    /**
     * Generate crud controllers
     *
     * @param Daguilarm\Belich\Core\Belich $belich
     */
    public function __construct(Belich $belich)
    {
        //Share the setting to all the views
        view()->share([
            'resources'      => $belich->resourcesAll(),
        ]);
    }

    /**
     * List the resource values.
     *
     * @param Daguilarm\Belich\Core\Belich $belich
     * @param Illuminate\Http\Request $request
     * @return array
     */
    public function getData(Belich $belich, Request $request)
    {
        //Set current resource
        $data   = $belich->currentResource($request);
        $fields = data_get($data, 'fields');

        $request->request->add([
            'autorizedModel' => $belich::getModel(),
            'actions'        => data_get($data, 'values.actions'),
            'breadcrumbs'    => data_get($data, 'values.breadcrumbs'),
            'fields'         => $fields,
            'name'           => data_get($data, 'name'),
            'results'        => data_get($data, 'results'),
            'total'          => Belich::count($fields, 2),
        ]);

        return $request;
    }

    /**
     * List some resource values.
     *
     * @param Daguilarm\Belich\Core\Belich $belich
     * @param Illuminate\Http\Request $request
     * @return array
     */
    public function getFormData(Belich $belich, Request $request, $id = null)
    {
        //Set current resource
        $data     = $belich->currentResource($request);
        $fields   = data_get($data, 'fields');

        $request->request->add([
            'breadcrumbs' => data_get($data, 'values.breadcrumbs'),
            'fields'      => $fields,
            'id'          => $id,
            'javascript'  => (new Validate)->create($data)->get('javascript'),
            'name'        => data_get($data, 'name'),
        ]);

        return $request;
    }
}
