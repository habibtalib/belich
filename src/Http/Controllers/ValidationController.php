<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

final class ValidationController extends Controller
{
    /**
     * Validate fields from ajax
     */
    public function __invoke(Request $request): JsonResponse
    {
        //Define the request variables
        $requestRules = $request->requestRules ?? [];
        $requestAttributes = $request->requestAttributes;
        $requestValues = $request->requestValues;

        //Do the validation...
        $validator = Validator::make($requestValues, $requestRules);

        //A little help with the localization...
        $validator->setAttributeNames($requestAttributes);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }

        return response()->json(['success']);
    }
}
