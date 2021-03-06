<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Components\Helpers;

use Daguilarm\Belich\Facades\Helper;
use Illuminate\Support\Collection;

trait Resources
{
    /**
     * Get all the resource names from folder
     * For auto route generation
     */
    public function getAllTheResourcesFromFolder(): Collection
    {
        //No file ... install case
        if (! file_exists(app_path('Belich/Resources'))) {
            return new Collection();
        }

        //Get all the files from folder
        return collect(scandir(app_path('Belich/Resources')))
            ->map(static function ($file) {
                return $file;
            })->filter(static function ($value) {
                return $value !== '.' && $value !== '..';
            })->map(static function ($file) {
                //Get the file
                $getFile = Helper::getFileAttributes($file);
                return Helper::stringPluralLower($getFile);
            });
    }
}
