<?php

namespace Daguilarm\Belich\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Daguilarm\Belich\Validations\Validation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ValidationController extends Controller
{
    /**
     * Validate fields from ajax
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //Default values
        $requestRules = $request->validationRules;
        $requestAttributes = $request->validationAttributes;
        $requestValues = $request->except([
            'validationRules',
            'validationAttributes'
        ]);

        //Do the validation...
        $validator = Validator::make($requestValues, $requestRules);

        //A little help with the localization...
        $validator->setAttributeNames($requestAttributes);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }

        return response()->json(['success']);
    }
}
