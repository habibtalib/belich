<?php

namespace Daguilarm\Belich\Components\Helpers;

use Illuminate\Support\Str;

trait Strings
{
    /**
     * Set the default value for a empty string or result
     *
     * @return string
     */
    public function emptyResults(): string
    {
        return '—';
    }

    /**
     * Set the string into migration format
     *
     * @param string $string
     *
     * @return string
     */
    public function stringPluralLower(string $string): string
    {
        return Str::plural(strtolower($string));
    }

    /**
     * Set the string into table column format
     *
     * @param string $string
     *
     * @return string
     */
    public function stringSingularLower(string $string): string
    {
        return Str::singular(strtolower($string));
    }

    /**
     * Set string into class name format
     *
     * @param string $string
     *
     * @return string
     */
    public function stringPluralUpper(string $string): string
    {
        return Str::plural(ucfirst($string));
    }

    /**
     * Set string into model format
     *
     * @param string $string
     *
     * @return string
     */
    public function stringSingularUpper(string $string): string
    {
        return Str::singular(ucfirst($string));
    }

    /**
     * Set string into kebab case
     *
     * @param string $string
     *
     * @return string
     */
    public function stringTokebab(string $string): string
    {
        return Str::kebab($string);
    }

    /**
     * Trim a string up to a maximum number of characters
     *
     * @param  string|null $string
     * @param  int $max
     * @param  string $end
     *
     * @return string|null
     */
    public function stringMaxChars(?string $string, int $max = 0, string $end = '...'): ?string
    {
        $max = $max <= 0
            ? config('belich.textAreaChars')
            : $max;

        return mb_strimwidth($string, 0, $max, $end);
    }

    /**
     * Set string into kebab case
     *
     * @param string $string
     *
     * @return string
     */
    public function stringTokebabLower(string $string): string
    {
        return Str::kebab(strtolower($string));
    }

    /**
     * String has a validad php structure
     *
     * @param  string $string
     *
     * @return bool
     */
    public function stringIsValidPhp(string $string): bool
    {
        return preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $string) === 1
            ? true
            : false;
    }

    /**
     * Remove stuff that may bother to Mr. php
     *
     * @param  string $string
     *
     * @return string
     */
    public function stringSanitize(string $string): string
    {
        $replace = ['!', '"', '/', '@', '#', '$', '%', '&', '(', ')', '€', '^', '*', '{', '}', '-', '.', ',', ';', ' '];

        return str_replace($replace, '_', $string);
    }
}
