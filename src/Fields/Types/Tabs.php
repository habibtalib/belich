<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Types\Panels;

final class Tabs extends Panels
{
    /**
     * Create a new panel
     */
    public static function create(string $name, callable $fields, ?string $background = null, ?string $color = null): array
    {
        // Get all the fields
        $fields = static::getFields($fields);

        return static::createFields($name, $fields);
    }
}
