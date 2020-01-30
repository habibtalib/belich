<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Resolves\Handler\Index\Types;

use Closure;
use Daguilarm\Belich\Contracts\HandleField;

final class Color implements HandleField
{
    private ?string $value;

    public function __construct(?string $value)
    {
        $this->value = $value;
    }

    /**
     * Resolve color value
     */
    public function handle(object $field, Closure $next): object
    {
        // Resolve show view for custom field
        if ($field->type === 'color' && isset($field->asColor) && $field->asColor === true) {
            // Set value
            $field->value = sprintf('<div class="w-12 h-2 rounded" style="background-color:%s">&nbsp;</div>', $this->value);
        }

        return $next($field);
    }
}
