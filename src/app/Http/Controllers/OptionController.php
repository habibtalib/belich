<?php

namespace Daguilarm\Belich\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    /**
     * Configure the Belich options
     *
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $redirect = redirect()
            ->back();

        if (!empty($request->perPage)) {
            $cookie = cookie('belich_perPage', $request->perPage, setTimeForCookie());
            $redirect = $redirect->withCookie($cookie);
        }

        if (!empty($request->withTrashed)) {
            $cookie = cookie('belich_withTrashed', $request->withTrashed, setTimeForCookie());
            $redirect = $redirect->withCookie($cookie);
        }

        return $redirect->withSuccess([trans('belich::messages.options.success')]);
    }
}
