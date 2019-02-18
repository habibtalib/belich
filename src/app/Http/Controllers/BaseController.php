<?php

namespace Daguilarm\Belich\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Daguilarm\Belich\Core\Belich;
use Daguilarm\Belich\Fields\FieldValidate as Validate;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

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
     * List the resource values for detail and index.
     *
     * @param Daguilarm\Belich\Core\Belich $belich
     * @param Illuminate\Http\Request $request
     * @return array
     */
    public function getData(Belich $belich, Request $request)
    {
        //Get the default values
        list($data, $fields) = $this->getDefaultValues($belich, $request);

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
     * List some resource values for create and edit
     *
     * @param Daguilarm\Belich\Core\Belich $belich
     * @param Illuminate\Http\Request $request
     * @return array
     */
    public function getFormData(Belich $belich, Request $request, $id = null)
    {
        //Get the default values
        list($data, $fields) = $this->getDefaultValues($belich, $request);

        $request->request->add([
            'breadcrumbs' => data_get($data, 'values.breadcrumbs'),
            'fields'      => $fields,
            'id'          => $id,
            'javascript'  => (new Validate)->create($data)->get('javascript'),
            'name'        => data_get($data, 'name'),
        ]);

        return $request;
    }

    /**
     * Redirect back with message
     *
     * @param boll $condition
     * @param string $success
     * @param string $error
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectBack(bool $condition, string $success, string $error) : RedirectResponse
    {
        $redirect = redirect()->back();

        return $condition
            //As array or will fail...
            ? $redirect->withSuccess([trans('belich::messages.crud.success', ['action' => $success])])
            //Is array by default so no need...
            : $redirect->withErrors(trans('belich::messages.crud.fail', ['action' => $error, 'email' => config('mail.from.address')]));
    }

    /**
     * Get the default values
     *
     * @param Daguilarm\Belich\Core\Belich $belich
     * @param Illuminate\Http\Request $request
     * @return array
     */
    private function getDefaultValues(Belich $belich, Request $request)
    {
        //Set default values
        $data = $belich->currentResource($request);

        return [$data, data_get($data, 'fields')];
    }
}
