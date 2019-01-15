<?php

namespace Daguilarm\Belich\Fields\Traits;

trait Filters {

    /**
     * String has a validad php structure
     *
     * @param  string $string
     * @return bool
     */
    private function stringHasValidPhpStructure(string $string) : bool
    {
        return (preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $string) === 1)
            ? true
            : false;
    }
}
