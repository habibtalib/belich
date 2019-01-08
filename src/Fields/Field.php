<?php

namespace Daguilarm\Belich\Fields;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\Str;

class Field {

    use Macroable;

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
     * The callback to be used to resolve the field's display value.
     *
     * @var \Closure
     */
    public $displayCallback;

    /**
     * The callback to be used to resolve the field's value.
     *
     * @var \Closure
     */
    public $resolveCallback;

    /**
     * The callback to be used to hydrate the model attribute.
     *
     * @var callable
     */
    public $fillCallback;

    /**
     * The validation rules for creation and updates.
     *
     * @var array
     */
    public $rules = [];

    /**
     * The validation rules for creation.
     *
     * @var array
     */
    public $creationRules = [];

    /**
     * The validation rules for updates.
     *
     * @var array
     */
    public $updateRules = [];

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
     * @param  mixed|null  $resolveCallback
     * @return void
     */
    public function __construct($name, $attribute = null, $resolveCallback = null)
    {
        $this->name = $name;
        $this->resolveCallback = $resolveCallback;
        $this->attribute = $attribute ?? str_replace(' ', '_', Str::lower($name));
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
}
