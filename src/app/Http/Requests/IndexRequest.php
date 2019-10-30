<?php

namespace Daguilarm\Belich\App\Http\Requests;

use Daguilarm\Belich\Core\Belich;
use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    /**
     * List the resource values for detail and index.
     *
     * @param Daguilarm\Belich\Core\Belich $belich
     * @return array
     */
    public function data(Belich $belich)
    {
        //Get the values for the resource
        $data   = $belich->currentResource($this);
        $fields = data_get($data, 'fields');

        //Add values to request
        $this->merge([
            'autorizedModel'        => $belich::getModel(),
            'actions'               => data_get($data, 'values.actions'),
            'breadcrumbs'           => data_get($data, 'values.breadcrumbs'),
            'cards'                 => data_get($data, 'values.cards'),
            'fields'                => $fields,
            'hideMetricsForScreens' => data_get($data, 'values.hideMetricsForScreens'),
            'metrics'               => data_get($data, 'values.metrics'),
            'name'                  => data_get($data, 'name'),
            'results'               => data_get($data, 'results'),
            'tableTextAlign'        => data_get($data, 'values.tableTextAlign'),
            'total'                 => $belich::count($fields->get('data'), 2),
        ]);

        return $this;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }
}
