<?php

namespace Daguilarm\Belich\Fields;

use Daguilarm\Belich\Fields\FieldBase;
use Daguilarm\Belich\Fields\Traits\Attributable;
use Daguilarm\Belich\Fields\Traits\Casteable;
use Daguilarm\Belich\Fields\Traits\Formatable;
use Daguilarm\Belich\Fields\Traits\Helpeable;
use Daguilarm\Belich\Fields\Traits\Ruleable;
use Daguilarm\Belich\Fields\Traits\Settingable;
use Daguilarm\Belich\Fields\Traits\Visibilitable;
use Illuminate\Support\Str;

class Field extends FieldBase
{
    use Attributable,
        Casteable,
        Formatable,
        Helpeable,
        Ruleable,
        Settingable,
        Visibilitable;

    /**
     * Create a new field
     *
     * @param  string  $name
     * @param  string|null  $attribute
     *
     * @return  void
     */
    public function __construct(string $label, ?string $attribute = null)
    {
        //Set the default value
        $title = str_replace(' ', '_', Str::lower($attribute));

        //Set the values
        $this->label = $label;
        $this->attribute = $attribute ?? $title;
        $this->dusk = $this->dusk ?? 'dusk-' . $title;
        $this->id = $this->name ?? $title;
        $this->name = $this->name ?? $title;
    }

    /**
     * Set the field attributes
     *
     * @param  string|null  $attributes
     *
     * @return Daguilarm\Belich\Fields\Field
     */
    public static function make(...$attributes): Field
    {
        //Set the field values
        return new static(...$attributes);
    }
}
