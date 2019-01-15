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
     * @param array $fields
     * @param string $controllerAction
     * @return object
     */
    public function make()
    {
        //Show or hide fields base on Resource settings
        $fields = $this->visibility($this->fields);

        //Resolve the field base on the Controller action
        return $this->resolveField($fields);
    }

    /*
    |--------------------------------------------------------------------------
    | Private methods
    |--------------------------------------------------------------------------
    */

    /**
     * Show or Hide field base on actions
     *
     * @param array $fields
     * @return array|null
     */
    private function visibility($fields)
    {
        return $fields->map(function($field) {
            return $field->visibility[$this->controllerAction]
                ? $field
                : null;
        })
        ->filter();
    }

    /**
     * Resolve the fields values base on the Controller action
     *
     * @return object
     */
    private function resolveField($fields) : Collection
    {
        //Index action: Return only the name and the attribute for each field.
        if($this->controllerAction === 'index') {
            return $this->indexValues($fields);
        }

        // Createing all the render attributes before added to the field
        $fields = $this->renderAttributes($fields);

        //Edit action
        //Show action
        if($this->controllerAction === 'edit' || $this->controllerAction === 'show') {
            //Fill the field value with the model
            return $this->setValue($fields);
        }

        return $fields;
    }

    /**
     * Set the values base on the index controller action
     *
     * @return object
     */
    private function indexValues($fields) : Collection
    {
        $results = $fields->mapWithKeys(function($field, $key) {
            return [$field->name => $field->attribute];
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
     * @return string|null
     */
    private function setValue($fields)
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
     * When the action is update or show
     * We hace to update the field value
     *
     * @param Illuminate\Support\Collection $fields
     * @return string|null
     */
    private function renderAttributes($fields)
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
