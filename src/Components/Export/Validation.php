<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Components\Export;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as Validate;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

final class Validation
{
    private static array $formats = ['xls', 'xlsx', 'csv'];
    private static array $selects = ['all', 'selected'];

    /**
     * Do the field validation
     */
    public static function make(Request $request): Validator
    {
        return Validate::make($request->all(), [
            'format' => ['required', Rule::in(static::$formats)],
            'quantity' => ['required', Rule::in(static::$selects)],
            'resource_model' => ['required',
                static function ($attribute, $value, $fail): void {
                    if (! class_exists($value)) {
                        $fail(trans('belich::messages.options.fail.class', ['value' => $value]));
                    }
                },
            ],
        ]);
    }
}
