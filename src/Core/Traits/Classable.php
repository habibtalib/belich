<?php

namespace Daguilarm\Belich\Core\Traits;

use Illuminate\Support\Str;

trait Classable
{
    /**
     * Set the class name
     *
     * @return string
     */
    public static function className(): string
    {
        $resource = request()->query('resourceName');

        $result = !empty($resource)
            ? $resource
            : static::resourceName();

        return static::classFormat($result);
    }

    /**
     * Set the class name
     *
     * @param string $className
     *
     * @return string
     */
    public static function classFormat(string $className): string
    {
        return Str::title(Str::singular($className));
    }
}
