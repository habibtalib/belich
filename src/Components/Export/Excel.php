<?php

namespace Daguilarm\Belich\Components\Export;

use Daguilarm\Belich\Components\Export\Eloquent;
use Daguilarm\Belich\Components\Export\File;
use Daguilarm\Belich\Components\Export\Validation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;

class Excel extends FastExcel
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
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function collection(Collection $data)
    {
        $this->data = $data;

        return $this;
    }
}
