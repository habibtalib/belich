<?php

namespace Daguilarm\Belich\Fields;

use Daguilarm\Belich\Core\Traits\Route as Helpers;
use Daguilarm\Belich\Fields\Field;
use Illuminate\Support\Collection;

class FieldResolve {

    use Helpers;

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
     * Show or Hide field base on actions
     *
     * @param object $class
     * @param string $controllerAction
     * @param object $fields
     * @return Illuminate\Support\Collection
     */
    public function make(object $class, object $fields, $sqlResponse) : Collection
    {
        //Policy authorization for 'show', 'edit' and 'update' actions
        //This go here because we want to avoid duplicated sql queries...Don't remove!!!
        $this->setAuthorizationForPolicy($sqlResponse);

        //Not apply
        if($this->action === 'store' || $this->action === 'update' || $this->action === 'destroy') {
            return new Collection;
        }

        //Authorized fields
        $fields = $this->setAuthorizationForFields($fields);

        //Show or hide fields base on Resource settings
        $fields = $this->setVisibilityForFields($fields);

        //Index action: Return only the name and the attribute for each field.
        if($this->action === 'index') {
            return $this->setIndexValues($fields);
        }

        //Form actions: Create or Edit
        if($this->action === 'create' || $this->action === 'edit') {
            // Creating all the render attributes for the forms
            $fields = $this->setAttributes($fields);
        }

        //Add values to fields: Only in Edit or Show actions
        if($this->action === 'edit' || $this->action === 'show') {
            //Fill the field value with the model
            return self::setValues($sqlResponse, $fields);
        }

        return $fields;
    }

    /**
     * Resolve field values for: relationship, displayUsing and resolveUsing
     * This method is used throw Belich Facade => Belich::html()->resolveField($field, $data);
     * This method is for refactoring the blade templates.
     *
     * @param  Daguilarm\Belich\Fields\Field $attribute
     * @param  object $data
     * @return string
     */
    public static function resolveField(Field $field, object $data = null) : string
    {
        //Relationship
        if(is_array($field->attribute) && count($field->attribute) === 2 && !empty($data)) {
            $value = $data->{$field->attribute[0]}->{$field->attribute[1]} ?? emptyResults();

        //Edit value
        } elseif(!empty($data)) {
            $value = $data->{$field->attribute} ?? emptyResults();

        //Show value
        } else {
            $value = $field->value;
        }

        //DisplayUsing
        if(is_callable($field->displayCallback)) {
            $value = call_user_func($field->displayCallback, $value);
        }

        //ResolveUsing
        if(is_callable($field->resolveCallback)) {
            //Add the data for the show view
            if(Belich::action() === 'show') {
                $data = $field->data;
            }

            $value = call_user_func($field->resolveCallback, $data);
        }

        return $value;
    }

    /*
    |--------------------------------------------------------------------------
    | Private methods
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
    private function setAuthorizationForPolicy(object $sqlResponse)
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
     * Set the values base on the index controller action
     *
     * @param Illuminate\Support\Collection $fields
     * @return Illuminate\Support\Collection
     */
    private function setIndexValues(Collection $fields) : Collection
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
     * Generate the attributes for the fields
     *
     * @param Illuminate\Support\Collection $fields
     * @return \Illuminate\Support\Collection
     */
    private function setAttributes(Collection $fields) : Collection
    {
        //Set attributes for each field
        return $fields->map(function($field) {

            //Add attributes dynamically from the list
            $field->render = collect($field)
                ->map(function($value, $attribute) use ($field) {
                    //Get the list of attributes to be rendered: name, dusk,...
                    if(in_array($attribute, $field->renderAttributes)) {
                        return sprintf('%s=%s', $attribute, $value);
                    }
                })
                ->filter(function($value) {
                    return $value;
                });

            //Add the data attributes
            if($field->data) {
                $data = collect($field->data)
                    ->map(function($value) {
                        return sprintf('data-%s=%s', $value[0], $value[1]);
                    })
                    ->implode(' ');

                $field->render->push($data);
            }

            //Add readonly attribute
            if($field->readonly) {
                $field->render->push('readonly');
            }

            //Add disabled attribute
            if($field->disabled) {
                $field->render->push('disabled');
            }

            //To string...
            $field->render = $field->render->implode(' ');

            return $field;
        });
    }

    /**
     * When the action is update or show
     * We have to update the field value
     *
     * @param Illuminate\Support\Collection $sqlResponse
     * @return Illuminate\Support\Collection
     */
    private function setValues(object $sqlResponse, Collection $fields) : Collection
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
}
