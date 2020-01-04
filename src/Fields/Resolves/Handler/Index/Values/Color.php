<?php

namespace Daguilarm\Belich\Fields\Resolves\Handler\Index\Values;

use Closure;
use Daguilarm\Belich\Contracts\HandleField;

final class Color implements HandleField
{
    /**
     * Resolve relationship
     *
     * @param object $field
     * @param Closure $next
     *
     * @return object
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
