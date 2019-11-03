<?php

namespace Daguilarm\Belich\Components\Export;

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
     * @return Daguilarm\Belich\Components\Export\Drivers\FastExcelDriver
     */
    public function collection(Collection $data);
}
