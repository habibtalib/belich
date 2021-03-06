<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Http\Requests;

use Daguilarm\Belich\Core\Belich;
use Daguilarm\Belich\Fields\Validates\Form;
use Daguilarm\Belich\Fields\Validates\Javascript;
use Daguilarm\Belich\Fields\Validates\Rules;
use Daguilarm\Belich\Fields\Validates\Validate;
use Daguilarm\Belich\Fields\Validates\Values;
use Illuminate\Foundation\Http\FormRequest;

final class EditRequest extends FormRequest
{
    /**
     * List the resource values for detail and index.
     */
    public function data(Belich $belich, int $id): self
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
            'autorizedModel' => data_get($data, 'results'),
            'breadcrumbs' => data_get($data, 'values.breadcrumbs'),
            'fields' => data_get($data, 'fields')->groupBy('panels'),
            'id' => $id,
            'javascript' => $validate->create($data)->get('javascript'),
            'name' => data_get($data, 'name'),
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
