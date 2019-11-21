<?php

namespace Daguilarm\Belich\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface ExportContract
{
    /**
     * Prepare the file for download
     *
     * @param Illuminate\Http\Request $request
     *
     * @return array
     */
    public function handle(Request $request): array;

    /**
     * Add collection from model
     *
     * @param Illuminate\Database\Eloquent\Collection $data
     *
     * @return Daguilarm\Belich\Components\Export\Drivers\FastExcelDriver
     */
    public function collection(Collection $data);
}