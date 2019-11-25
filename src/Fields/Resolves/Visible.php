<?php

namespace Daguilarm\Belich\Fields\Resolves;

use Illuminate\Support\Collection;

final class Visible
{
    /**
     * Show or Hide field base on the controller action
     *
     * @param  string  $action
     * @param Illuminate\Support\Collection $fields
     *
     * @return Illuminate\Support\Collection
     */
    public function execute(string $action, Collection $fields): Collection
    {
        return $fields->map(static function ($field) use ($action) {
            if (in_array($action, $field->forceVisibility)) {
                //If the field has the visibility for this controller action on true...
                return $field->visibility[$action]
                    ? $field
                    : null;
            }

            return null;
        })
            //Delete all null results from the collection
            ->filter();
    }
}
