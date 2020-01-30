<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Resolves\Handler\Index\Resolve;

use Closure;
use Daguilarm\Belich\Contracts\HandleField;

final class Color implements HandleField
{
    /**
     * Resolve Color field
     */
    public function handle(object $field, Closure $next): object
    {
        // Resolve color
        if ($field->type === 'color' && isset($field->asColor) && $field->asColor === true) {
            // Set value
            $field->asHtml();
        }

        return $next($field);
    }
}
