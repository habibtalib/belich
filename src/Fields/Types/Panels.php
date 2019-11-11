<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Types\Header;
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
    public static function create(string $name, callable $fields, ?string $background = null, ?string $color = null): array
    {
        // Get all the fields and create the header
        $fields = static::getFields($fields)
            ->prepend(
                Header::make($name)
                    ->visibleOn('show', 'create', 'edit')
                    ->background($background)
                    ->color($color)
            );

        return $fields
            ->map(static function ($field) use ($color, $name) {
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
