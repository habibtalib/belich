<?php

namespace Daguilarm\Belich\Contracts;

interface FieldContract
{
    /**
     * Get the URI key for the card
     *
     * @param array $attributes
     */
    public static function make(...$attributes);
}
