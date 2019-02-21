<?php

namespace Daguilarm\Belich\Fields;

use Daguilarm\Belich\Contracts\Maker;
use Daguilarm\Belich\Fields\FieldAbstract;
use Daguilarm\Belich\Fields\Traits\Attributes;
use Daguilarm\Belich\Fields\Traits\Messages;
use Daguilarm\Belich\Fields\Traits\Rules;
use Daguilarm\Belich\Fields\Traits\Settings;
use Daguilarm\Belich\Fields\Traits\Visibility;
use Illuminate\Support\Str;

class Field extends FieldAbstract {

    use Attributes,
        Messages,
        Rules,
        Settings,
        Visibility;

    /**
     * Create a new field
     *
     * @param  string  $name
     * @param  string|null  $attribute
     */
    public function __construct($label, $attribute = null)
    {
        //Set the default value
        $title = str_replace(' ', '_', Str::lower($attribute));

        //Set the values
        $this->label             = $label;
        $this->attribute         = $attribute ?? $title;
        $this->dusk              = $this->dusk ?? 'dusk-' . $title;
        $this->id                = $this->name ?? $title;
        $this->name              = $this->name ?? $title;
    }

    /**
     * Set the field attributes
     *
     * @param  string|null  $attributes
     * @return Daguilarm\Belich\Fields\Field
     */
    public static function make(...$attributes) : Field
    {
        //Set the field values
        return new static(...$attributes);
    }
}
