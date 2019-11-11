<?php

namespace Daguilarm\Belich\Fields\Types;

use Illuminate\Support\Collection;

final class Panels
{
    /**
     * Create a new panel
     *
     * @param  string  $name
     * @param  \Closure  $fields
     *
     * @return array
     */
    public static function create(string $name, callable $fields): array
    {
        return static::getFields($fields)
            ->map(static function ($field) use ($name) {
                return $field
                    ->panels($name);
            })
            // Not repeat attributes
            ->unique('attribute')
            ->toArray();
    }

    /**
     * Resolve fields in callback
     *
     * @param  \Closure  $fields
     *
     * @return Illuminate\Support\Collection
     */
    private static function getFields(callable $fields): Collection
    {
        $listOfFields = call_user_func($fields);

        return collect($listOfFields);
    }
}
