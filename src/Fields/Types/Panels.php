<?php

namespace Daguilarm\Belich\Fields\Types;

use Illuminate\Support\Collection;

class Panels {

    /**
     * Create a new tab
     *
     * @param  string  $name
     * @param  \Closure  $fields
     * @return array
     */
    public static function create(string $name, callable $fields) : array
    {
        return static::getFields($fields)
            ->map(function($field) use ($name) {
                return $field->panels($name);
            })
            ->toArray();
    }

    /**
     * Resolve closure
     *
     * @param  \Closure  $fields
     * @return Illuminate\Support\Collection
     */
    private static function getFields(callable $fields) : Collection
    {
        $listOfFields = call_user_func($fields);

        return collect($listOfFields);
    }
}
