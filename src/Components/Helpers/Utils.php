<?php

namespace Daguilarm\Belich\Components\Helpers;

trait Utils
{
    /**
     * Convert a field string (coma separated values) into an array
     * Only works on numeric
     * This is for using mass selection and $model->whereIn($array)
     *
     * @param string $values
     *
     * @return array
     */
    public function fieldToArray(string $values): array
    {
        $listOfValues = explode(',', $values);

        return collect($listOfValues)
            ->map(static function ($value) {
                // Only numeric values
                if (isset($value) && is_numeric($value)) {
                    return (int) $value;
                }
            })
            ->filter()
            ->toArray();
    }

    /**
     * Get the object name
     *
     * @param object $object
     *
     * @return string
     */
    public function objectName(object $object): string
    {
        $array = explode('\\', get_class($object));

        return end($array);
    }

    /**
     * Validate url
     *
     * @param string $url
     *
     * @return string
     */
    function validateUrl($url)
    {
        return filter_var($url, FILTER_VALIDATE_URL);
    }
}
