<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Components\Export\Drivers;

use Daguilarm\Belich\Components\Export\Drivers\MaatwebsiteDriver;
use Daguilarm\Belich\Components\Export\Eloquent;
use Daguilarm\Belich\Components\Export\File;
use Daguilarm\Belich\Components\Export\Validation;
use Daguilarm\Belich\Contracts\ExportContract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

/**
 * @Driver: Laravel Maatwebsite excel
 *
 * @Github: https://laravel-excel.maatwebsite.nl/
 */
final class MaatwebsiteDriver implements ExportContract
{
    /**
     * @var Collection
     */
    private $data;

    /**
     * Prepare the file for download
     */
    public function handle(Request $request): array
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
     */
    public function collection(Collection $data): MaatwebsiteDriver
    {
        $this->data = $data;

        return $this;
    }
}
