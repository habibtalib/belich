<?php

namespace Daguilarm\Belich\Fields\Types;

use Carbon\Carbon;
use Daguilarm\Belich\Fields\Field;

class Date extends Field
{
    /** @var string */
    public $type = 'date';

    /** @var string */
    public $format;

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
        $this->resolveUsing(function ($model) {
            // Get the current date
            $date = $model->{$this->attribute};
            //Get the format
            $format = $this->format ?? config('belich.dateFormat');

            return Carbon::createFromFormat('Y-m-d', $date)->format($format);
        });
    }

    /**
     * Set the output format for date
     * Will be use in the actions: index and show
     * Edit and create use the input date standard -> browser default.
     *
     * @param  string|null  $name
     * @param  string|null  $attribute
     *
     * @return  self
     */
    public function format(string $format): self
    {
        $this->format = $format;

        return $this;
    }
}
