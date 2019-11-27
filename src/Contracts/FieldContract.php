<?php

namespace Daguilarm\Belich\Contracts;

use Daguilarm\Belich\Fields\Types\Relationship;

interface FieldContract
{
    /**
     * Get the URI key for the card
     *
     * @param array $attributes
     *
     * @return Daguilarm\Belich\Fields\Relationship
     */
    public static function make(...$attributes);
}
