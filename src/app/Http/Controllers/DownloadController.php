<?php

namespace Daguilarm\Belich\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Daguilarm\Belich\Components\Export\Operations;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;

class DownloadController extends Controller
{
    /**
     * Configure the Belich options
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //Create a export to excel instance
        $export = (new Operations)->handle($request);

        // Do the validation
        $validator = $export->get('validation');

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator->messages()->first());
        }

        //Set values
        $file  = $export->get('file');
        $query = $export->get('query');

        //Download the file
        return (new FastExcel($query))->download($file);
    }
}
