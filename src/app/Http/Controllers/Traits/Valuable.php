<?php

namespace Daguilarm\Belich\App\Http\Controllers\Traits;

use Daguilarm\Belich\Core\Belich;
use Daguilarm\Belich\Fields\FieldValidate as Validate;
use Illuminate\Http\Request;

trait Valuable {

    /**
     * List the resource values for detail and index.
     *
     * @param Daguilarm\Belich\Core\Belich $belich
     * @param Illuminate\Http\Request $request
     * @return array
     */
    protected function dataToIndex(Belich $belich, Request $request)
    {
        //Get the default values
        list($data, $fields) = $this->getDefaultValues($belich, $request);

        $request->request->add([
            'autorizedModel'        => $belich::getModel(),
            'actions'               => data_get($data, 'values.actions'),
            'breadcrumbs'           => data_get($data, 'values.breadcrumbs'),
            'cards'                 => data_get($data, 'values.cards'),
            'fields'                => $fields,
            'hideMetricsForScreens' => data_get($data, 'values.hideMetricsForScreens'),
            'metrics'               => data_get($data, 'values.metrics'),
            'name'                  => data_get($data, 'name'),
            'results'               => data_get($data, 'results'),
            'total'                 => Belich::count($fields, 2),
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
    protected function dataToForms(Belich $belich, Request $request, $id = null)
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

        return [
            $data,
            data_get($data, 'fields')
        ];
    }
}
