<?php

namespace Daguilarm\Belich\Fields\Traits\Constructable;

trait Authorizable {

    /**
     * Determine if the field should be available for the given request.
     *
     * @param  object  $fields
     * @return bool
     */
    private function setAuthorizationForFields(object $fields)
    {
        return $fields->map(function($field) {
            if($this->canSeeField($field)) {
                return $field;
            }
        })
        ->filter();
    }

    /**
     * Determine if the user has been authorized to see the field: $field->canSee()
     *
     * @param  object  $field
     * @return bool
     */
    private function canSeeField(object $field)
    {
        return empty($field->seeCallback) || (is_callable($field->seeCallback) && call_user_func($field->seeCallback, request()) !== false);
    }

    /**
     * Determine if the user can access to the resource
     * See resource Policy
     *
     * @param  object  $sqlResponse
     * @return bool
     */
    private function setAuthorizationFromPolicy(object $sqlResponse)
    {
        //Authorized access to show action
        if($this->action === 'show') {
            if(!request()->user()->can('view', $sqlResponse)) {
                return abort(403);
            }
        }

        //Authorized access to edit or update action
        if($this->action === 'edit' || $this->action === 'update') {
            if(!request()->user()->can('update', $sqlResponse)) {
                return abort(403);
            }
        }
    }
}
