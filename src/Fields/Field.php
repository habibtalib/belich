<?php

namespace Daguilarm\Belich\Fields;

use Daguilarm\Belich\Contracts\Maker;
use Daguilarm\Belich\Fields\FieldAbstract;
use Daguilarm\Belich\Fields\FieldRules;
use Daguilarm\Belich\Fields\FieldSettings;
use Daguilarm\Belich\Fields\FieldVisibility;
use Illuminate\Support\Str;

class Field extends FieldAbstract {

    use FieldRules,
        FieldSettings,
        FieldVisibility;

    /**
     * Create a new field
     *
     * @param  string  $name
     * @param  string|null  $attribute
     * @return void
     */
    public function __construct($name, $attribute = null)
    {
        $this->name      = $name;
        $this->attribute = $attribute ?? str_replace(' ', '_', Str::lower($name));
    }

    /**
     * Set the field attributes
     *
     * @param  string|null  $attributes
     * @return object
     */
    public static function make(...$attributes) : Field
    {
        //Set the field values
        return new static(...$attributes);
    }
}
