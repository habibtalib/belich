<?php

namespace Daguilarm\Belich\Fields;

use Daguilarm\Belich\Fields\FieldTraits\Methods;
use Daguilarm\Belich\Fields\FieldTraits\Rules;
use Daguilarm\Belich\Fields\FieldTraits\Visibilities;
use Illuminate\Support\Str;

class Field {

    use Methods, Rules, Visibilities;

    /**
     * Set the controller action
     *
     * @var string
     */
    public $action;

    /**
     * The attribute / column name of the field.
     *
     * @var string
     */
    public $attribute;

    /**
     * The displayable name of the field.
     *
     * @var string
     */
    public $name;

    /**
     * Indicates if the field should be sortable.
     *
     * @var bool
     */
    public $sortable = false;

    /**
     * Create a new field
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
}
