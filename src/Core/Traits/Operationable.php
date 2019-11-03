<?php

namespace Daguilarm\Belich\Core\Traits;

trait Operationable
{
    /*
    |--------------------------------------------------------------------------
    | Public Static Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Count the total results
     *
     * @param  array|object $value
     * @param  int $initialValue
     *
     * @return integer
     */
    public static function count($value, int $initialValue = 0) : int
    {
        if (is_array($value)) {
            return count($value) + $initialValue;
        }

        if (is_object($value)) {
            return $value->count() + $initialValue;
        }

        return 0;
    }
}
