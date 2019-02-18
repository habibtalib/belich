<?php

namespace Daguilarm\Belich\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OptionsController extends Controller
{
    private $time = 60 * 24 * 31 * 12;

    /**
     * Configure the Belich options
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $redirect = redirect()
            ->back();

        if(!empty($request->perPage)) {
            $cookie = cookie('belich_perPage', $request->perPage, $this->time);
            $redirect = $redirect->withCookie($cookie);
        }

        if(!empty($request->withTrashed)) {
            $cookie = cookie('belich_withTrashed', $request->withTrashed, $this->time);
            $redirect = $redirect->withCookie($cookie);
        }

        return $redirect->withSuccess(['Your settings has been stored!']);
    }
}
