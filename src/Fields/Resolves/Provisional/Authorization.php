<?php

namespace Daguilarm\Belich\Fields\Resolves;

final class Authorization
{
    /**
     * Determine if the field should be available for the given request.
     *
     * @param  object  $fields
     *
     * @return bool
     */
    public function fields(object $fields)
    {
        return $fields->map(function ($field) {
            return $this->canSee($field)
                ? $field
                : null;
        })
            ->filter();
    }

    /**
     * Determine if the user can access to the resource
     * See resource Policy
     *
     * @param  object  $sql
     * @param  string  $action
     *
     * @return bool
     */
    public function policy(object $sql, string $action)
    {
        //Authorized access to show action
        if ($action === 'show' && ! request()->user()->can('view', $sql)) {
            return abort(403);
        }

        //Authorized access to edit or update action
        if (($action === 'edit' || $action === 'update') && ! request()->user()->can('update', $sql)) {
            return abort(403);
        }
    }

    /**
     * Determine if the user has been authorized to see the field: $field->canSee()
     *
     * @param  object  $field
     *
     * @return bool
     */
    private function canSee(object $field)
    {
        return ! isset($field->seeCallback) || (is_callable($field->seeCallback) && call_user_func($field->seeCallback, request()) !== false);
    }
}
