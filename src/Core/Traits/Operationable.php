<?php

namespace Daguilarm\Belich\Core\Traits;

trait Operationable
{
    /**
     * Count the total results
     *
     * @param  mixed $value
     * @param  int $initialValue
     *
     * @return int
     */
    public static function count($value, int $initialValue = 0): int
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
