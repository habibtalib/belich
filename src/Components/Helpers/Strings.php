<?php

namespace Daguilarm\Belich\Components\Helpers;

use Illuminate\Support\Str;

trait Strings
{
    /**
     * Set the string into migration format
     *
     * @return string
     */
    private function stringPluralLower($string): string
    {
        return Str::plural(strtolower($string));
    }

    /**
     * Set string into class name format
     *
     * @return string
     */
    private function stringPluralUpper($string): string
    {
        return Str::plural(ucfirst($string));
    }

    /**
     * Set string into model format
     *
     * @return string
     */
    private function stringSingularUpper($string): string
    {
        return Str::singular(ucfirst($string));
    }

    /**
     * Set string into kebab case
     *
     * @return string
     */
    private function stringTokebab($string): string
    {
        return Str::kebab($string);
    }

    /**
     * Set the default value for a empty string or result
     *
     * @return string
     */
    private function emptyResults(): string
    {
        return '—';
    }
}
