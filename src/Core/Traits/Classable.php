<?php

namespace Daguilarm\Belich\Core\Traits;

use Illuminate\Support\Str;

trait Classable {

    /**
     * Set the class name
     *
     * @return string
     */
    public static function className() : string
    {
        $resource = request()->query('resourceName');

        return !empty($resource)
            ? static::classFormat($resource)
            : static::resourceName();
    }

    /**
     * Set the class name
     *
     * @param string $className
     * @return string
     */
    public static function classFormat($className) : string
    {
        return Str::title(Str::singular($className));
    }
}