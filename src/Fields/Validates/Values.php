<?php

namespace Daguilarm\Belich\Fields\Validates;

use Daguilarm\Belich\Fields\Validates\Rules;
use Illuminate\Support\Collection;

final class Values
{
    /**
     * Get the values from the fields.
     *
     * @param Illuminate\Support\Collection $resource
     *
     * @return Illuminate\Support\Collection
     */
    public function get(Collection $resource, Rules $rules, string $controllerAction): Collection
    {
        return $resource['fields']
            ->mapWithKeys(static function ($field) use ($controllerAction, $rules) {
                return [
                    $field->id => [
                        $field->label,
                        $field->id ?? null,
                        //Define the rules base on the action
                        $rules->create($field, $controllerAction),
                    ],
                ];
            })->filter(static function ($field): bool {
                // Removed empty fields with database relation, like: Header::make().
                return isset($field[0]) && $field[0] && isset($field[1]) && $field[1];
            });
    }
}
