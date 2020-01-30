<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Http\Controllers;

use App\Http\Controllers\Controller;
use Daguilarm\Belich\Facades\Helper;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class OptionController extends Controller
{
    /**
     * Configure the Belich options
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $redirect = redirect()
            ->back();

        if (isset($request->perPage)) {
            $cookie = cookie('belich_perPage', $request->perPage, Helper::timeForCookie());
            $redirect = $redirect->withCookie($cookie);
        }

        if (isset($request->withTrashed)) {
            $cookie = cookie('belich_withTrashed', $request->withTrashed, Helper::timeForCookie());
            $redirect = $redirect->withCookie($cookie);
        }

        return $redirect->withSuccess([trans('belich::messages.options.success')]);
    }
}
