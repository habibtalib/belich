<?php

namespace Daguilarm\Belich\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Daguilarm\Belich\Core\Download;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class DownloadController extends Controller
{
    /** @var array */
    private $formats = ['xls', 'xlsx', 'csv'];

    /**
     * Configure the Belich options
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // Do the validation
        $validator = $this->validation($request);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator->messages()->first());
        }

        //Get all the parameters
        list($class, $fileName, $exportFormat) = $this->handle($request);

        return Excel::download($class, $fileName, $exportFormat);
    }

    /**
     * Handle the download
     *
     * @param Illuminate\Http\Request $request
     * @return array
     */
    private function handle(Request $request) : array
    {
        // Get the current model
        $model = $this->model($request);

        //Set the variables
        $class = $this->exportClass($model, $request);
        $fileName = $this->getFileName($model, $request);

        //Load the extensión
        $exportFormat = $this->exportFormat($request);

        return [$class, $fileName, $exportFormat];
    }

    /**
     * Exporting format
     *
     * @param Illuminate\Http\Request $request
     * @return Maatwebsite\Excel\Facades\Excel
     */
    public function exportFormat(Request $request)
    {
        if($request->format === 'xls') {
            return \Maatwebsite\Excel\Excel::XLS;
        }

        if($request->format === 'pdf') {
            return \Maatwebsite\Excel\Excel::DOMPDF;
        }

        if($request->format === 'xlsx') {
            return \Maatwebsite\Excel\Excel::XLSX;
        }

        if($request->format === 'tsv') {
            return \Maatwebsite\Excel\Excel::TSV;
        }

        if($request->format === 'tsv') {
            return \Maatwebsite\Excel\Excel::TSV;
        }

        if($request->format === 'ods') {
            return \Maatwebsite\Excel\Excel::ODS;
        }
    }

    /**
     * Get the file name
     *
     * @param object $model
     * @param Illuminate\Http\Request $request
     * @return string
     */
    private function getFileName(object $model, Request $request) : string
    {
        return sprintf('%s.%s', $model->getTable(), $request->format);
    }

    /**
     * Get the current model
     *
     * @param Illuminate\Http\Request $request
     * @return object
     */
    private function model(Request $request) : object
    {
        return app($request->resource_model);
    }

    /**
     * Get the export class
     *
     * @param object $model
     * @return \Illuminate\Http\Response
     */
    public function exportClass(object $model, Request $request)
    {
        return new Download($model, $request);
    }

    /**
     * Do the field validation
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    private function validation(Request $request)
    {
        return Validator::make($request->all(), [
            'format'   => ['required', Rule::in($this->formats)],
            'quantity' => ['required',
                Rule::in([
                    trans('belich::default.all'),
                    trans('belich::default.selected')
                ]),
            ],
            'resource_model' => ['required',
                function ($attribute, $value, $fail) {
                    if(!class_exists($value)) {
                        $fail(trans('belich::messages.options.fail.class', ['value' => $value]));
                    }
                },
            ],
        ]);
    }
}
