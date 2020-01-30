<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Http\Requests;

use Daguilarm\Belich\Core\Belich;
use Illuminate\Foundation\Http\FormRequest;

final class IndexRequest extends FormRequest
{
    /**
     * List the resource values for detail and index.
     */
    public function data(Belich $belich): self
    {
        //Get the values for the resource
        $data = $belich->currentResource($this);
        $fields = data_get($data, 'fields');

        //Add values to request
        $this->merge([
            'autorizedModel' => $belich::getModel(),
            'actions' => data_get($data, 'values.actions'),
            'breadcrumbs' => data_get($data, 'values.breadcrumbs'),
            'cards' => data_get($data, 'values.cards'),
            'fields' => $fields,
            'hideMetricsForScreens' => data_get($data, 'values.hideMetricsForScreens'),
            'metrics' => data_get($data, 'values.metrics'),
            'name' => data_get($data, 'name'),
            'results' => data_get($data, 'results'),
            'tableTextAlign' => data_get($data, 'values.tableTextAlign'),
            'total' => $belich::count($fields->get('data'), 2),
        ]);

        return $this;
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [];
    }
}
