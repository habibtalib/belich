<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Components\Export;

final class Excel
{
    /**
     * Select driver from config file
     */
    public static function make(): object
    {
        /**
         * @Driver: Laravel Maatwebsite excel
         *
         * @Github: https://laravel-excel.maatwebsite.nl/
         */
        if (static::getDriver() === 'maatwebsite') {
            return new \Daguilarm\Belich\Components\Export\Drivers\MaatwebsiteDriver();
        }

        /**
         * @Driver: FastExcel
         *
         * @Github: https://github.com/rap2hpoutre/fast-excel
         */
        if (static::getDriver() === 'fast-excel') {
            return new \Daguilarm\Belich\Components\Export\Drivers\FastExcelDriver();
        }

        throw new \InvalidArgumentException('Invalid Download driver. Please check your config file, and select a correct one.');
    }

    /**
     * Get driver from config file
     */
    public static function getDriver(): ?string
    {
        return config('belich.export.driver') ?? null;
    }
}
