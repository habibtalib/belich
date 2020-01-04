<?php

namespace Daguilarm\Belich\Fields\Resolves\Handler\Crud\Types;

use Closure;
use Daguilarm\Belich\Contracts\HandleField;

final class Color implements HandleField
{
    /**
     * Handle color field
     *
     * @param object $field
     * @param Closure $next
     *
     * @return object
     */
    public function handle(object $field, Closure $next): object
    {
        // Resolve show view for custom field
        if ($field->type === 'color' && isset($field->asColor) && $field->asColor === true) {
            // Set value
            $field->asHtml()->value = sprintf(
                '<div class="w-12 h-2 rounded" style="background-color:%s">&nbsp;</div>',
                $field->value
            );
        }

        return $next($field);
    }
}
