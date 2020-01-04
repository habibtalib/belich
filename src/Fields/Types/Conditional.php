<?php

namespace Daguilarm\Belich\Fields\Types;

use Illuminate\Support\Collection;

class Conditional
{
    public static $fields;

    /**
     * Get the fields and prepare its for condition
     *
     * @param  \Closure  $fields
     *
     * @return array
     */
    public static function make(callable $fields)
    {
        self::$fields = static::getFields($fields);

        return new self();
    }

    /**
     * Create conditional fields
     *
     * @param  string  $parent
     * @param  bool|null  $value
     *
     * @return array
     */
    public function dependsOn(string $parent, ?bool $value)
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
     *
     * @param  \Closure  $fields
     *
     * @return Illuminate\Support\Collection
     */
    protected static function getFields(callable $fields): Collection
    {
        $listOfFields = call_user_func($fields);

        return collect($listOfFields);
    }
}
