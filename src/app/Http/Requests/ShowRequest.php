<?php

namespace Daguilarm\Belich\App\Http\Requests;

use Daguilarm\Belich\Core\Belich;
use Illuminate\Foundation\Http\FormRequest;

final class ShowRequest extends FormRequest
{
    /**
     * List the resource values for detail and index.
     *
     * @param Daguilarm\Belich\Core\Belich $belich
     * @param int $id
     *
     * @return self
     */
    public function data(Belich $belich, int $id): self
    {
        //Get the values for the resource
        $data = $belich->currentResource($this);

        //Add values to request
        $this->merge([
            'autorizedModel' => $belich::getModel(),
            'breadcrumbs' => data_get($data, 'values.breadcrumbs'),
            'fields' => data_get($data, 'fields')->groupBy('panels'),
            'id' => $id,
            'name' => data_get($data, 'name'),
            'results' => data_get($data, 'results'),
        ]);

        return $this;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [];
    }
}
