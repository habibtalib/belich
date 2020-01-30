<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Http\Requests;

use Daguilarm\Belich\Http\Requests\Traits\Casteable;
use Daguilarm\Belich\Http\Requests\Traits\Fileable;
use Illuminate\Foundation\Http\FormRequest;

final class UpdateRequest extends FormRequest
{
    use Casteable,
        Fileable;

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
