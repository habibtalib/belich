<?php

namespace Daguilarm\Belich\Components\Export;

use Daguilarm\Belich\Components\Export\Eloquent;
use Illuminate\Http\Request;

final class File
{
    /**
     * Exporting format
     *
     * @param Illuminate\Http\Request $request
     *
     * @return string
     */
    public static function format(Request $request): string
    {
        return $request->format ?? 'xlsx';
    }

    /**
     * Get the file name
     *
     * @param Illuminate\Http\Request $request
     *
     * @return string
     */
    public static function name(Request $request): string
    {
        return sprintf('%s.%s', Eloquent::tableName($request), static::format($request));
    }
}
