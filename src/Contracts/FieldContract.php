<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Contracts;

interface FieldContract
{
    /**
     * Get the URI key for the card
     */
    public static function make(...$attributes);
}
