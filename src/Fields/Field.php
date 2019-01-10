<?php

namespace Daguilarm\Belich\Fields;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class Field {

    /**
     * Set the controller action
     *
     * @var string
     */
    public $action;

    /**
     * The displayable name of the field.
     *
     * @var string
     */
    public $name;

    /**
     * The attribute / column name of the field.
     *
     * @var string
     */
    public $attribute;

    /**
     * The field's resolved value.
     *
     * @var mixed
     */
    public $value;

    /**
     * The validation rules for creation and updates.
     *
     * @var array
     */
    public $rules;

    /**
     * The validation rules for creation.
     *
     * @var array
     */
    public $creationRules;

    /**
     * The validation rules for updates.
     *
     * @var array
     */
    public $updateRules;

    /**
     * Indicates if the field should be sortable.
     *
     * @var bool
     */
    public $sortable = false;

    /**
     * Help text
     *
     * @var string
     */
    public $help;

    /**
     * Create a new field.
     *
     * @param  string  $name
     * @param  string|null  $attribute
     * @return void
     */
    public function __construct($name, $attribute = null)
    {
        $this->name = $name;
        $this->attribute = $attribute ?? str_replace(' ', '_', Str::lower($name));
        $this->action = getRouteAction();
    }

    /**
     * Set the field attributes
     *
     * @param  string|null  $attributes
     * @return object
     */
    public static function make(...$attributes) {
        //Set the field values
        return new static(...$attributes);
    }

    /**
     * Set the field attributes
     *
     * @param  string|null  $attributes
     * @return object
     */
    public function defaultValue($value = null) {
        //Check the value for conditional cases...
        if(!is_null($value)) {
            $this->value = $value;
        }

        return $this;
    }

    /**
     * Set a help text for the field
     *
     * @param  string  $text
     * @return void
     */
    public function help($text = null)
    {
        //Check the text for conditional cases...
        if(!is_null($text)) {
            $this->help = $text;
        }

        return $this;
    }

    /**
     * Hydrate the given attribute on the model based on the incoming request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  object  $model
     * @return mixed
     */
    public function fill(Request $request, $model)
    {
        return;
    }

    /**
     * Set a general rules for validation
     *
     * @param  array  $rules
     * @return void
     */
    public function rules(...$rules)
    {
        //Check the text for conditional cases...
        $this->rules = $rules;
        $this->creationRules = null;
        $this->updateRules = null;

        return $this;
    }

    /**
     * Set a creation rules for validation
     *
     * @param  array  $rules
     * @return void
     */
    public function creationRules(...$rules)
    {
        //Check the text for conditional cases...
        $this->creationRules = $rules;

        return $this;
    }

    /**
     * Set a update rules for validation
     *
     * @param  array  $rules
     * @return void
     */
    public function updateRules(...$rules)
    {
        //Check the text for conditional cases...
        $this->updateRules = $rules;

        return $this;
    }
}
