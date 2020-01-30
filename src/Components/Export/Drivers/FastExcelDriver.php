<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Components\Export\Drivers;

use Daguilarm\Belich\Components\Export\Eloquent;
use Daguilarm\Belich\Components\Export\File;
use Daguilarm\Belich\Components\Export\Validation;
use Daguilarm\Belich\Contracts\ExportContract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;

/**
 * @Driver: FastExcel
 *
 * @Github: https://github.com/rap2hpoutre/fast-excel
 */
final class FastExcelDriver extends FastExcel implements ExportContract
{
    /**
     * @var Collection
     */
    protected $data;
    protected array $select = [];

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
    public function collection(Collection $data): FastExcelDriver
    {
        $this->data = $this->select
            ? $data->select($this->select)
            : $data;

        return $this;
    }
}
