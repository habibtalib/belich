<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Facades\Helper;
use Daguilarm\Belich\Fields\Types\Header;
use Illuminate\Support\Collection;

class Panels
{
    /**
     * Create a new panel
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

        return static::createFields($name, $fields);
    }

    /**
     * Resolve fields in callback
     */
    protected static function getFields(callable $fields): Collection
    {
        $listOfFields = call_user_func($fields);

        return collect($listOfFields);
    }

    /**
     * Resolve fields in callback
     */
    protected static function createFields(string $name, Collection $fields): array
    {
        return $fields
            ->map(static function ($field) use ($name) {
                // Add the tabs id
                $field->tabulationID = md5(Helper::stringTokebab($name));

                return $field->panels($name);
            })
            ->toArray();
    }
}
