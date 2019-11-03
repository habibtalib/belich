<?php

namespace Daguilarm\Belich\Fields\Traits;

trait Filterable
{
    /**
     * String has a validad php structure
     *
     * @param  string $string
     * @return bool
     */
    protected function stringHasValidPhpStructure(string $string) : bool
    {
        return (preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $string) === 1)
            ? true
            : false;
    }

    /**
     * Remove stuff that may bother to Mr. php
     *
     * @param  string $string
     * @return bool
     */
    protected function stringSanitizeForPhpStructure(string $string) : string
    {
        $replace = ['!', '"', '/', '@', '#', '$', '%', '&', '(', ')', '€', '^', '*', '{', '}', '-', '.', ',', ';', ' '];

        return str_replace($replace, '_', $string);
    }
}
