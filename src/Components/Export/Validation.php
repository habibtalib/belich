<?php

namespace Daguilarm\Belich\Components\Export;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Validation
{
    /** @var array */
    private static $formats = ['xls', 'xlsx', 'csv'];

    /** @var array */
    private static $selects = ['all', 'selected'];

    /**
     * Do the field validation
     *
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public static function make(Request $request): Validator
    {
        return Validator::make($request->all(), [
            'format' => ['required', Rule::in(static::$formats)],
            'quantity' => ['required', Rule::in(static::$selects)],
            'resource_model' => ['required',
                static function ($attribute, $value, $fail): void {
                    if (!class_exists($value)) {
                        $fail(trans('belich::messages.options.fail.class', ['value' => $value]));
                    }
                },
            ],
        ]);
    }
}
