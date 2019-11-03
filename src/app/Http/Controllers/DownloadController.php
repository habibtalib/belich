<?php

namespace Daguilarm\Belich\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Daguilarm\Belich\Components\Export\Excel;
use Illuminate\Http\Request;

class DownloadController extends Controller
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
        //Get the excel instance from the driver
        $excel = Excel::make();

        //Handle the excel values
        [$file, $query, $validator] = $excel->handle($request);

        //Handle validation
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator->messages()->first());
        }

        //Download the file
        return $excel->collection($query)->download($file);
    }
}
