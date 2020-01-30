<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Types;

use Illuminate\Support\Collection;

class Conditional
{
    public static object $fields;

    /**
     * Get the fields and prepare its for condition
     */
    public static function make(callable $fields)
    {
        self::$fields = static::getFields($fields);

        return new self();
    }

    /**
     * Create conditional fields
     */
    public function dependsOn(string $parent, ?bool $value): array
    {
        return self::$fields
            ->map(static function ($field) use ($parent, $value) {
                $field->dependsOn = $parent;
                $field->dependsOnValue = $value;
                $field->hideFromIndex();

                return $field;
            })
            ->toArray();
    }

    /**
     * Resolve fields in callback
     */
    protected static function getFields(callable $fields): Collection
    {
        $listOfFields = call_user_func($fields);

        return collect($listOfFields);
    }
}
