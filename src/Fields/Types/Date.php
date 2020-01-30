<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Types;

use Carbon\Carbon;
use Daguilarm\Belich\Fields\Field;

final class Date extends Field
{
    public string $type = 'date';
    public string $format;

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
     */
    public function format(string $format): self
    {
        $this->format = $format;

        return $this;
    }

    /**
     * Disabled method
     * Resolve the value as HTML (without scape)
     */
    public function asHtml(): Field
    {
        return $this;
    }

    /**
     * Disabled method
     * Resolving field value in index and detailed
     */
    public function displayUsing(callable $displayCallback): Field
    {
        return $this;
    }

    /**
     * Disabled method
     * Prefix for field value
     */
    public function prefix(string $prefix, bool $space = false): Field
    {
        return $this;
    }

    /**
     * Disabled method
     * Suffix for field value
     */
    public function suffix(string $suffix, bool $space = false): Field
    {
        return $this;
    }
}
