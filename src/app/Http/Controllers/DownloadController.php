<?php

namespace Daguilarm\Belich\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Daguilarm\Belich\Components\Export\Excel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class DownloadController extends Controller
{
    /**
     * Configure the Belich options
     *
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request): RedirectResponse
    {
        //Get the excel instance from the driver
        $excel = Excel::make();

        //Handle the excel values
        [$file, $query, $validator] = $excel->handle($request);

        return $validator->fails()
            //Handle validation
            ? redirect()->back()->withErrors($validator->messages()->first())
            //Download the file
            : $excel->collection($query)->download($file);
    }
}
