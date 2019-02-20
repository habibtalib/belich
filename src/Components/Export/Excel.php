<?php

namespace Daguilarm\Belich\Components\Export;

use Illuminate\Http\Request;

class Excel {

    /**
     * Select driver from config file
     *
     * @return object
     */
    public static function make() : object
    {
        /**
         * @Driver: Laravel Maatwebsite excel
         * @Github: https://laravel-excel.maatwebsite.nl/
         */
        if(static::getDriver() === 'maatwebsite') {
            return new \Daguilarm\Belich\Components\Export\Drivers\MaatwebsiteDriver;
        }

        /**
         * @Driver: FastExcel
         * @Github: https://github.com/rap2hpoutre/fast-excel
         */
        return new \Daguilarm\Belich\Components\Export\Drivers\FastExcelDriver;
    }

    /**
     * Get driver from config file
     *
     * @return string|null
     */
    public static function getDriver()
    {
        return config('belich.export.driver') ?? null;
    }
}
