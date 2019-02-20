<?php

namespace Daguilarm\Belich\Components\Export\Drivers;

use Daguilarm\Belich\Components\Export\Eloquent;
use Daguilarm\Belich\Components\Export\ExportContract;
use Daguilarm\Belich\Components\Export\File;
use Daguilarm\Belich\Components\Export\Validation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

/**
 * @Driver: Laravel Maatwebsite excel
 * @Github: https://laravel-excel.maatwebsite.nl/
 */
class MaatwebsiteDriver implements ExportContract
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
        return [];
    }

    /**
     * Add collection from model
     *
     * @return Daguilarm\Belich\Components\Export\Drivers\MaatwebsiteDriver
     */
    public function collection(Collection $data) : MaatwebsiteDriver
    {
        $this->data = $data;

        return $this;
    }
}
