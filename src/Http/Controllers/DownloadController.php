<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Http\Controllers;

use App\Http\Controllers\Controller;
use Daguilarm\Belich\Components\Export\Excel;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

final class DownloadController extends Controller
{
    /**
     * Execute a download
     */
    public function __invoke(Request $request): StreamedResponse
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
