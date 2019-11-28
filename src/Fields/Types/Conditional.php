<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Facades\Helper;
use Daguilarm\Belich\Fields\Types\Header;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Conditional
{
    /**
     * Create a new panel
     *
     * @param  \Closure  $fields
     * @param  string  $dependsOn
     * @param  bool|null  $dependsOnValue
     *
     * @return array
     */
    public static function create(string $dependsOn, ?bool $dependsOnValue, callable $fields): array
    {
        // Get all the fields
        $fields = static::getFields($fields);

        return static::createFields($fields, $dependsOn, $dependsOnValue);
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
     * @param  bool|null  $dependsOnValue
     *
     * @return array
     */
    protected static function createFields(Collection $fields, string $dependsOn, ?bool $dependsOnValue): array
    {
        $uriKey = Str::random(16);

        return $fields
            ->map(static function ($field) use ($dependsOn, $dependsOnValue, $uriKey) {
                $field->dependsOn = $dependsOn;
                $field->dependsOnValue = $dependsOnValue;
                $field->dependsOnKey = $uriKey;
                $field->hideFromIndex();

                return $field;
            })
            ->toArray();
    }
}
