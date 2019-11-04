<?php

namespace Daguilarm\Belich\Components\Helpers;

trait Utils
{
    /**
     * Convert a field string (coma separated values) into an array
     * Only works on numeric
     * This is for using mass selection and $model->whereIn($array)
     *
     * @return array
     */
    private function fieldToArray($values): array
    {
        $listOfValues = explode(',', $values);

        return collect($listOfValues)
            ->map(static function ($value) {
                // Only numeric values
                if (!empty($value) && is_numeric($value)) {
                    return (int) $value;
                }
            })
            ->filter()
            ->toArray();
    }
}
