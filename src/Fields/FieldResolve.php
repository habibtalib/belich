<?php

namespace Daguilarm\Belich\Fields;

use Daguilarm\Belich\Fields\Field;
use Daguilarm\Belich\Core\Traits\Route as Helpers;
use Daguilarm\Belich\Fields\Traits\Resolve;
use Illuminate\Support\Collection;

class FieldResolve {

    use Helpers, Resolve;

    /** @var string */
    private $action;

    /**
     * Get controller action
     *
     * @return string
     */
    public function __construct()
    {
        $this->action = Helpers::action();
    }

    /**
     * Resolve fields: auth, visibility, value,...
     *
     * @param object $class
     * @param object $fields
     * @param object $sqlResponse
     * @return Illuminate\Support\Collection
     */
    public function make(object $class, object $fields, object $sqlResponse) : Collection
    {
        //Policy authorization for 'show', 'edit' and 'update' actions
        //This go here because we want to avoid duplicated sql queries...Don't remove!!!
        $this->setAuthorizationFromPolicy($sqlResponse);

        //Authorized fields: $field->canSee()
        $fields = $this->setAuthorizationForFields($fields);

        //Show or hide fields base on Resource settings
        $fields = $this->setVisibilityForFields($fields);

        //Resolve fields base on the controller action
        return $this->setControllerActionForFields($fields, $sqlResponse);
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

    /*
    |--------------------------------------------------------------------------
    | Values for fields
    |--------------------------------------------------------------------------
    */

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
