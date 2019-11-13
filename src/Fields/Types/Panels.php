<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Types\Header;
use Illuminate\Support\Collection;

class Panels
{
    /**
     * Create a new panel
     *
     * @param  string  $name
     * @param  \Closure  $fields
     * @param  string|null  $background
     * @param  string|null  $color
     *
     * @return array
     */
    public static function create(string $name, callable $fields, ?string $background = null, ?string $color = null): array
    {
        // Get all the fields
        $fields = static::getFields($fields)
            ->prepend(
                // Create the header
                Header::make($name)
                    ->visibleOn('show', 'create', 'edit')
                    ->background($background)
                    ->color($color)
            );

        return static::setFields($name, $fields);
    }

    /**
     * Resolve fields in callback
     *
     * @param  string  $name
     * @param  \Closure  $fields
     *
     * @return Illuminate\Support\Collection
     */
    protected static function getFields(callable $fields): Collection
    {
        $listOfFields = call_user_func($fields);

        return collect($listOfFields);
    }

    /**
     * Resolve fields in callback
     *
     * @param  \Closure  $fields
     * @param Illuminate\Support\Collection $fields
     *
     * @return array
     */
    protected static function setFields(string $name, Collection $fields): array
    {
        return $fields
            ->map(static function ($field) use ($name) {
                return $field->panels($name);
            })
            // Not repeat attributes
            ->unique('attribute')
            ->toArray();
    }
}
