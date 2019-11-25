<?php

namespace Daguilarm\Belich\App\Http\Requests;

use Daguilarm\Belich\Core\Belich;
use Daguilarm\Belich\Fields\Validates\Form;
use Daguilarm\Belich\Fields\Validates\Javascript;
use Daguilarm\Belich\Fields\Validates\Rules;
use Daguilarm\Belich\Fields\Validates\Validate;
use Daguilarm\Belich\Fields\Validates\Values;
use Illuminate\Foundation\Http\FormRequest;

final class CreateRequest extends FormRequest
{
    /**
     * List the resource values for detail and index.
     *
     * @param Daguilarm\Belich\Core\Belich $belich
     *
     * @return self
     */
    public function data(Belich $belich): self
    {
        //Get the values for the resource
        $data = $belich->currentResource($this);
        $validate = new Validate(
            new Form(),
            new Javascript(),
            new Rules(),
            new Values()
        );

        //Add values to request
        $this->merge([
            'breadcrumbs' => data_get($data, 'values.breadcrumbs'),
            'fields' => data_get($data, 'fields')->groupBy('panels'),
            'javascript' => $validate->create($data)->get('javascript'),
            'name' => data_get($data, 'name'),
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
