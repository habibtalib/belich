<?php

namespace Daguilarm\Belich\Fields\Types;

use Carbon\Carbon;
use Daguilarm\Belich\Fields\Field;

class Date extends Field {

    /** @var string */
    public $type = 'date';

    /**
     * Create a new field.
     *
     * @param  string|null  $name
     * @param  string|null  $attribute
     */
    public function __construct($name = null, $attribute = null)
    {
        parent::__construct($name, $attribute);

        //Cast the field as string
        $this->toDate('Y-m-d');

        //Resolving the date
        $this->resolveUsing(function($model) {
            return Carbon::createFromFormat('Y-m-d', $model->{$this->attribute})->format('d/m/Y');
        });
    }
}
