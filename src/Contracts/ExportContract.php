<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface ExportContract
{
    /**
     * Prepare the file for download
     */
    public function handle(Request $request): array;

    /**
     * Add collection from model
     */
    public function collection(Collection $data);
}
