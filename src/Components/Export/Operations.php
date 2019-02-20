<?php

namespace Daguilarm\Belich\Components\Export;

use Daguilarm\Belich\Components\Export\Eloquent;
use Daguilarm\Belich\Components\Export\File;
use Daguilarm\Belich\Components\Export\Validation;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class Operations
{
    /**
     * Prepare the file for download
     *
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Support\Collection
     */
    public function handle(Request $request) : Collection
    {
        //Validation
        $validation = Validation::make($request);

        // Load users
        $query = Eloquent::query($request);

        //File name
        $file = File::name($request);

        // Return the values
        return collect([
            'validation' => $validation,
            'query'      => $query,
            'file'       => $file,
        ]);
    }
}
