<?php

namespace Daguilarm\Belich\Contracts;

interface Maker {

    /**
     * Generate an object with attributes
     *
     * @param string|array $attributes
     * @return object
     */
    public static function make(...$attributes);
}
