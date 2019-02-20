<?php

namespace Daguilarm\Belich\Components\Export\Drivers;

use Daguilarm\Belich\Components\Export\Eloquent;
use Daguilarm\Belich\Components\Export\ExportContract;
use Daguilarm\Belich\Components\Export\File;
use Daguilarm\Belich\Components\Export\Validation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;

/**
 * @Driver: FastExcel
 * @Github: https://github.com/rap2hpoutre/fast-excel
 */
class FastExcelDriver extends FastExcel implements ExportContract
{
    /**
     * @var Collection
     */
    protected $data;

    /**
     * Prepare the file for download
     *
     * @param Illuminate\Http\Request $request
     * @return array
     */
    public function handle(Request $request) : array
    {
        // Handle the values
        return [
            File::name($request),
            Eloquent::query($request),
            Validation::make($request),
        ];
    }

    /**
     * Add collection from model
     *
     * @return Daguilarm\Belich\Components\Export\Drivers\FastExcelDriver
     */
    public function collection(Collection $data) : FastExcelDriver
    {
        $this->data = $data;

        return $this;
    }
}
