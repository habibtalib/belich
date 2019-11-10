<?php

namespace Daguilarm\Belich\Fields;

use Illuminate\Support\Collection;

class FieldResolveBase
{
    /**
     * Set the values base on the controllers action (except for index)
     *
     * @param Illuminate\Support\Collection $fields
     * @param object $sqlResponse
     * @param string $action
     *
     * @return Illuminate\Support\Collection
     */
    protected function setCrudController(object $fields, object $sqlResponse, string $action): object
    {
        //Set fields attributes: Only for create and edit actions
        if ($action === 'create' || $action === 'edit') {
            // Creating all the render attributes for the forms
            $fields = $this->setAttributesForFields($fields);
        }

        //Resolve values for fields: Only for Edit or Show actions
        if ($action === 'edit' || $action === 'show') {
            //Fill the field value with the model
            return $this->setValueForFields($sqlResponse, $fields);
        }

        return $fields;
    }

    /**
     * Show or Hide field base on the controller action
     *
     * @param Illuminate\Support\Collection $fields
     * @param  string  $action
     *
     * @return Illuminate\Support\Collection
     */
    protected function setVisibilityForFields(Collection $fields, string $action): Collection
    {
        return $fields->map(static function ($field) use ($action) {
            //If the field has the visibility for this controller action on true...
            return $field->visibility[$action]
                ? $field
                : null;
        })
            //Delete all null results from the collection
            ->filter();
    }

    /**
     * Determine if the field should be available for the given request.
     *
     * @param  object  $fields
     *
     * @return bool
     */
    protected function setAuthorizationForFields(object $fields)
    {
        return $fields->map(function ($field) {
            return $this->canSeeField($field)
                ? $field
                : null;
        })
            ->filter();
    }

    /**
     * Determine if the user can access to the resource
     * See resource Policy
     *
     * @param  object  $sqlResponse
     * @param  string  $action
     *
     * @return bool
     */
    protected function setAuthorizationFromPolicy(object $sqlResponse, string $action)
    {
        //Authorized access to show action
        if ($action === 'show' && !request()->user()->can('view', $sqlResponse)) {
            return abort(403);
        }

        //Authorized access to edit or update action
        if (($action === 'edit' || $action === 'update') && !request()->user()->can('update', $sqlResponse)) {
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
    private function canSeeField(object $field)
    {
        return !isset($field->seeCallback) || (is_callable($field->seeCallback) && call_user_func($field->seeCallback, request()) !== false);
    }

    /**
     * Generate the attributes for the fields
     *
     * @param Illuminate\Support\Collection $fields
     *
     * @return \Illuminate\Support\Collection
     */
    private function setAttributesForFields(Collection $fields): Collection
    {
        //Set attributes for each field
        return $fields->map(function ($field) {

            //Add attributes dynamically from the list
            $field->render = $this->setRenderFieldAttributes($field);

            //Add autofocus attribute
            if ($field->autofocus) {
                $field->render->push('autofocus');
            }

            //Add the data attributes
            if ($field->data) {
                $field->render->push($this->setRenderFieldAttributesData($field));
            }

            //Add readonly attribute
            if ($field->readonly && $field->type !== 'hidden') {
                $field->render->push('readonly');
            }

            //Add disabled attribute
            if ($field->disabled) {
                $field->render->push('disabled');
            }

            //Render field
            return $this->renderField($field);
        });
    }
}
