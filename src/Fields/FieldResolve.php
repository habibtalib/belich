<?php

namespace Daguilarm\Belich\Fields;

use Daguilarm\Belich\Fields\Field;
use Illuminate\Support\Collection;

class FieldResolve {

    /** @var string [The controller action name] */
    private $controllerAction;

    /** @var Illuminate\Support\Collection [The field attributes] */
    private $fields;

    /** @var object [The resource model] */
    private $model;

    /**
     * Resolve the field
     *
     * @param  string  $controllerAction
     * @param  Collection  $fields
     * @param  object  $model
     * @return void
     */
    public function __construct(string $controllerAction, Collection $fields, $model)
    {
        $this->controllerAction = $controllerAction;
        $this->fields           = $fields;
        $this->model            = $model;
    }

    /**
     * Show or Hide field base on actions
     *
     * @return Illuminate\Support\Collection
     */
    public function make() : Collection
    {
        //Show or hide fields base on Resource settings
        $fields = $this->setVisibilities($this->fields);

        //Index action: Return only the name and the attribute for each field.
        if($this->controllerAction === 'index') {
            return $this->setIndexValues($fields);
        }

        //Form actions: Create or Edit
        if($this->controllerAction === 'create' || $this->controllerAction === 'edit') {
            // Creating all the render attributes for the forms
            $fields = $this->setAttributes($fields);
        }

        //Add values to fields: Only in Edit or Show actions
        if($this->controllerAction === 'edit' || $this->controllerAction === 'show') {
            //Fill the field value with the model
            return $this->setValues($fields);
        }

        return $fields;
    }

    /*
    |--------------------------------------------------------------------------
    | Private methods
    |--------------------------------------------------------------------------
    */

    /**
     * Show or Hide field base on actions
     *
     * @param Illuminate\Support\Collection $fields
     * @return array|null
     */
    private function setVisibilities(Collection $fields) : Collection
    {
        return $fields->map(function($field) {
            return $field->visibility[$this->controllerAction]
                ? $field
                : null;
        })
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
        $results = $fields->mapWithKeys(function($field, $key) {
            return [$field->label => $field->attribute];
        });

        return collect([
            'attributes' => $results->values(),
            'labels'     => $results->keys(),
        ]);
    }

    /**
     * When the action is update or show
     * We hace to update the field value
     *
     * @param Illuminate\Support\Collection $fields
     * @return Illuminate\Support\Collection
     */
    private function setValues(Collection $fields) : Collection
    {
        return $fields->map(function($field) {
            //Get the attribute value
            $attribute = $field->attribute;

            //Set new value
            $field->value = optional($this->model)->{$field->attribute};

            return $field;
        });
    }

    /**
     * Generate the attributes for the fields
     *
     * @param Illuminate\Support\Collection $fields
     * @return \Illuminate\Support\Collection
     */
    private function setAttributes($fields) : Collection
    {
        return $fields->map(function($field) {

            //Add attributes dynamically from the list
            $field->render = collect($field)
                ->map(function($value, $attribute) use ($field) {
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
}
