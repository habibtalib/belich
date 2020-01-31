<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Components\Helpers;

use Illuminate\Support\Str;

trait Strings
{
    /**
     * Set the default value for a empty string or result
     */
    public function emptyResults(): string
    {
        return '—';
    }

    /**
     * Set the string into migration format
     */
    public function stringPluralLower(?string $string): string
    {
        return $string
            ? Str::plural(strtolower($string))
            : null;
    }

    /**
     * Set the string into table column format
     */
    public function stringSingularLower(?string $string): string
    {
        return $string
            ? Str::singular(strtolower($string))
            : null;
    }

    /**
     * Set string into class name format
     */
    public function stringPluralUpper(?string $string): string
    {
        return $string
            ? Str::plural(ucfirst($string))
            : null;
    }

    /**
     * Set string into model format
     */
    public function stringSingularUpper(?string $string): string
    {
        return $string
            ? Str::singular(ucfirst($string))
            : null;
    }

    /**
     * Set string into kebab case
     */
    public function stringTokebab(?string $string): string
    {
        return $string
            ? Str::kebab($string)
            : null;
    }

    /**
     * Trim a string up to a maximum number of characters
     */
    public function stringMaxChars(?string $string, int $max = 0, string $end = '...'): ?string
    {
        $max = $max <= 0
            ? config('belich.textAreaChars')
            : $max;

        return $string
            ? mb_strimwidth($string, 0, $max, $end)
            : null;
    }

    /**
     * Set string into kebab case
     */
    public function stringTokebabLower(?string $string): string
    {
        return $string
            ? Str::kebab(strtolower($string))
            : null;
    }

    /**
     * String has a validad php structure
     */
    public function stringIsValidPhp(?string $string): bool
    {
        return preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $string) === 1
            ? true
            : false;
    }

    /**
     * Remove stuff that may bother to Mr. php
     */
    public function stringSanitize(?string $string): string
    {
        $replace = ['!', '"', '/', '@', '#', '$', '%', '&', '(', ')', '€', '^', '*', '{', '}', '-', '.', ',', ';', ' '];

        return str_replace($replace, '_', $string);
    }
}
