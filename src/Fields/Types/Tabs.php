<?php

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Types\Panels;

final class Tabs extends Panels
{
    /**
     * Create a new panel
     *
     * @param  string  $name
     * @param  \Closure  $fields
     *
     * @return array
     */
    public static function create(string $name, callable $fields, ?string $background = null, ?string $color = null): array
    {
        // Get all the fields
        $fields = static::getFields($fields);

        return static::setFields($name, $fields);
    }
}
