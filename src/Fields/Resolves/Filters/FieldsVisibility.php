<?php

namespace Daguilarm\Belich\Fields\Resolves\Filters;

use Closure;
use Daguilarm\Belich\Facades\Belich;
use Illuminate\Support\Collection;

final class FieldsVisibility
{
    /**
     * @var string
     */
    private $action;

    /**
     * Init constructor
     *
     * @param object $sql
     * @param string $action
     *
     * @return Illuminate\Support\Collection
     */
    public function __construct()
    {
        $this->action = Belich::action();
    }

    /**
     * Show or Hide field base on the controller action
     *
     * @param  string  $action
     * @param Illuminate\Support\Collection $fields
     *
     * @return Illuminate\Support\Collection
     */
    public function handle($fields, Closure $next): Collection
    {
        $fields = $fields->map(function ($field) {
            // Hide not editable fields from a relationship
            if (isset($field->editableRelationship) && $field->editableRelationship === false) {
                $field->visibility['create'] = false;
            }

            // Hide or show fields
            if (in_array($this->action, $field->forceVisibility)) {
                //If the field has the visibility for this controller action on true...
                return $field->visibility[$this->action]
                    ? $field
                    : null;
            }

            return null;
        })
            //Delete all null results from the collection
            ->filter();

        // I dont know Why...
        return $this->action === 'index'
            ? $fields
            : $next($fields);
    }
}
