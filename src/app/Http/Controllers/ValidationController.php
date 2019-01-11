<?php

namespace Daguilarm\Belich\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Daguilarm\Belich\Validations\Validation;
use Illuminate\Http\Request;

class ValidationController extends Controller
{
    public function __invoke(Request $request)
    {
        $validator = \Validator::make($request->except(['validationRules', 'validationAttributes']), $request->validationRules);
        $validator->setAttributeNames($request->validationAttributes);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        } else {
            return response()->json(['success']);
        }
    }
}
