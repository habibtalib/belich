<?php

namespace Daguilarm\Belich\Fields\Traits;

use Illuminate\Support\Collection;

trait Resolvable {

    /** @var array */
    private $conditionalBag;

    /*
    |--------------------------------------------------------------------------
    | Controller actions
    |--------------------------------------------------------------------------
    */

    /**
     * Set the field values base on the controller actions
     *
     * @param Illuminate\Support\Collection $fields
     * @param object $sqlResponse
     * @return Illuminate\Support\Collection
     */
    public function setControllerActionForFields(object $fields, object $sqlResponse) : Collection
    {
        //No resolve field for not visual actions
        if($this->action === 'store' || $this->action === 'update' || $this->action === 'destroy') {
            return new Collection;
        }

        //Prepare the field for the index response
        if($this->action === 'index') {
            return $this->setControllerForIndex($fields);

        //Prepare the field for the the form response: create, edit and show
        } else {
            return $this->setController($fields, $sqlResponse);
        }

        return $fields;
    }

    /**
     * Set the values base on the index controller action
     *
     * @param Illuminate\Support\Collection $fields
     * @return Illuminate\Support\Collection
     */
    private function setControllerForIndex(Collection $fields) : Collection
    {
        return $fields->map(function($field) {
            //Showing field relationship in index
            //See blade template: dashboard.index
            $field->attribute = $field->fieldRelationship
                //Prepare field for relationship
                ? [$field->fieldRelationship, $field->attribute]
                //No relationship field
                : $field->attribute;

            return $field;
        });
    }

    /**
     * Set the values base on the controllers action (except for index)
     *
     * @param Illuminate\Support\Collection $fields
     * @param object $sqlResponse
     * @return Illuminate\Support\Collection
     */
    public function setController(object $fields, object $sqlResponse)
    {
        //Set fields attributes: Only for create and edit actions
        if($this->action === 'create' || $this->action === 'edit') {
            // Creating all the render attributes for the forms
            $fields = $this->setAttributesForFields($fields);
        }

        //Resolve values for fields: Only for Edit or Show actions
        if($this->action === 'edit' || $this->action === 'show') {
            //Fill the field value with the model
            return $this->setValueForFields($sqlResponse, $fields);
        }

        return $fields;
    }

    /*
    |--------------------------------------------------------------------------
    | Auth methods
    |--------------------------------------------------------------------------
    */

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
        if(empty($field->seeCallback) || (is_callable($field->seeCallback) && call_user_func($field->seeCallback, request()) !== false)) {
            return true;
        }
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

    /*
    |--------------------------------------------------------------------------
    | Attributes
    |--------------------------------------------------------------------------
    */

    /**
     * Show or Hide field base on the controller action
     *
     * @param Illuminate\Support\Collection $fields
     * @return array|null
     */
    private function setVisibilityForFields(Collection $fields) : Collection
    {
        return $fields->map(function($field) {
            //If the field has the visibility for this controller action on true...
            return $field->visibility[$this->action]
                ? $field
                : null;
        })
        //Delete all null results from the collection
        ->filter();
    }

    /**
     * Generate the attributes for the fields
     *
     * @param Illuminate\Support\Collection $fields
     * @return \Illuminate\Support\Collection
     */
    private function setAttributesForFields(Collection $fields) : Collection
    {
        //Set attributes for each field
        return $fields->map(function($field) {

            //Add attributes dynamically from the list
            $field->render = $this->setRenderFieldAttributes($field);

            //Add autofocus attribute
            if($field->autofocus) {
                $field->render->push('autofocus');
            }

            //Add the data attributes
            if($field->data) {
                $field->render->push($this->setRenderFieldAttributesData($field));
            }

            //Add readonly attribute
            if($field->readonly) {
                $field->render->push('readonly');
            }

            //Add disabled attribute
            if($field->disabled) {
                $field->render->push('disabled');
            }

            //Render field
            return $this->renderField($field);
        });
    }

    /**
     * When the action is update or show
     * We have to update the field value
     *
     * @param Illuminate\Support\Collection $sqlResponse
     * @return Illuminate\Support\Collection
     */
    private function setValueForFields(object $sqlResponse, Collection $fields) : Collection
    {
        return $fields->map(function($field) use ($sqlResponse) {
            //Not resolve field value
            //Mostly, this is a hidden field...
            if($field->notResolveField) {
                return $field;
            }

            //Set new value for the fields, even if has a fieldRelationship value
            //This relationship method is only on forms
            //Index has its own way in blade template
            $field->value = self::setValuesWithFieldRelationship($sqlResponse, $field);

            //Add the data for the show view
            if($this->action === 'show') {
                $field->data = $sqlResponse;
            }

            return $field;
        });
    }

    /**
     * Determine value with relationship if exists...
     *
     * @param Illuminate\Support\Collection $sqlResponse
     * @param Illuminate\Support\Collection $fields
     * @return Illuminate\Support\Collection
     */
    private function setValuesWithFieldRelationship(object $sqlResponse, object $field)
    {
        if($field->fieldRelationship) {
            return $sqlResponse->{$field->fieldRelationship}->{$field->attribute} ?? null;
        }

        return $sqlResponse->{$field->attribute} ?? null;
    }

    /*
    |--------------------------------------------------------------------------
    | Render field attributes
    |--------------------------------------------------------------------------
    */

    private function setRenderFieldAttributes($field)
    {
        return collect($field)
            ->map(function($value, $attribute) use ($field) {
                //Get the list of attributes to be rendered: name, dusk,...
                if(in_array($attribute, $field->renderAttributes)) {
                    return sprintf('%s=%s', $attribute, $value);
                }
            })
            ->filter(function($value) {
                return $value;
            });
    }

    private function setRenderFieldAttributesData($field)
    {
        return collect($field->data)
            ->map(function($value) {
                return sprintf('data-%s=%s', $value[0], $value[1]);
            })
            ->implode(' ');
    }

    private function renderField($field)
    {
        //To string...
        $field->render = $field->render->implode(' ');

        return $field;
    }
}
