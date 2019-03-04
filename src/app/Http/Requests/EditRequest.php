<?php

namespace Daguilarm\Belich\App\Http\Requests;

use Daguilarm\Belich\Core\Belich;
use Daguilarm\Belich\Fields\FieldValidate;
use Illuminate\Foundation\Http\FormRequest;

class EditRequest extends FormRequest
{
    /**
     * List the resource values for detail and index.
     *
     * @param Daguilarm\Belich\Core\Belich $belich
     * @return array
     */
    public function data(Belich $belich, $id)
    {
        //Get the values for the resource
        $data     = $belich->currentResource($this);
        $validate = new FieldValidate;

        //Add values to request
        $this->merge([
            'breadcrumbs' => data_get($data, 'values.breadcrumbs'),
            'fields'      => data_get($data, 'fields')->groupBy('panels'),
            'id'          => $id,
            'javascript'  => $validate->create($data)->get('javascript'),
            'name'        => data_get($data, 'name'),
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
