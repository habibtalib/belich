<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Facades\Helper;
use Daguilarm\Belich\Fields\Types\Header;
use Illuminate\Support\Collection;

class Conditional
{
    /**
     * Create a new panel
     *
     * @param  \Closure  $fields
     * @param  string  $dependsOn
     * @param  bool|null  $dependensOnValue
     *
     * @return array
     */
    public static function make(callable $fields, string $dependsOn, ?bool $dependensOnValue): array
    {
        // Get all the fields
        $fields = static::getFields($field);

        return static::createFields($fields, $dependsOn, $dependensOnValue);
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
     * @param Illuminate\Support\Collection $fields
     * @param  string  $dependsOn
     * @param  bool|null  $dependensOnValue
     *
     * @return array
     */
    protected static function createFields(Collection $fields, string $dependsOn, ?bool $dependensOnValue): array
    {
        return $fields
            ->map(static function ($field) use ($dependsOn, $dependensOnValue) {
                return $field;
            })
            ->toArray();
    }
}
