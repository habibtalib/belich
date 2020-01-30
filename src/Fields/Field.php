<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields;

use Daguilarm\Belich\Contracts\FieldContract;
use Daguilarm\Belich\Fields\FieldBase;
use Daguilarm\Belich\Fields\Traits\Attributable;
use Daguilarm\Belich\Fields\Traits\Authorizable;
use Daguilarm\Belich\Fields\Traits\Casteable;
use Daguilarm\Belich\Fields\Traits\Conditionable;
use Daguilarm\Belich\Fields\Traits\Formatable;
use Daguilarm\Belich\Fields\Traits\Helpeable;
use Daguilarm\Belich\Fields\Traits\Prefixable;
use Daguilarm\Belich\Fields\Traits\Renderable;
use Daguilarm\Belich\Fields\Traits\Resolvable;
use Daguilarm\Belich\Fields\Traits\Ruleable;
use Daguilarm\Belich\Fields\Traits\Settingable;
use Daguilarm\Belich\Fields\Traits\Visibilitable;
use Illuminate\Support\Str;

abstract class Field extends FieldBase implements FieldContract
{
    use Attributable,
        Authorizable,
        Casteable,
        Conditionable,
        Formatable,
        Helpeable,
        Prefixable,
        Renderable,
        Resolvable,
        Ruleable,
        Settingable,
        Visibilitable;

    public function __construct(string $label, ?string $attribute = null, ?string $model = null)
    {
        //Set the default value
        $title = str_replace(' ', '_', Str::lower($attribute));

        //Set the values
        $this->label = $label;
        $this->attribute = $attribute ?? $title;
        $this->dusk = $this->dusk ?? 'dusk-' . $title;
        $this->id = $this->name ?? $title;
        $this->name = $this->name ?? $title;
        $this->uriKey = md5($this->id);
    }

    /**
     * Set the field attributes
     */
    public static function make(...$attributes): Field
    {
        //Set the field values
        return new static(...$attributes);
    }
}
