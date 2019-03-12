<?php

namespace Daguilarm\Belich\App\Http\Requests;

use Daguilarm\Belich\App\Http\Requests\Traits\Casteable;
use Daguilarm\Belich\App\Http\Requests\Traits\Fileable;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    use Casteable, Fileable;

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
