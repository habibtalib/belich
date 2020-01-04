<?php

namespace Daguilarm\Belich\Fields\Resolves\Filters\Types;

use Closure;
use Daguilarm\Belich\Contracts\HandleField;

final class Boolean implements HandleField {
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
        if (isset($field->trueValue) && isset($field->falseValue)) {
            $field->value = $field->value
                ? $field->trueValue
                : $field->falseValue;
        } else {
            $field->value = sprintf('<i class="fas fa-circle text-%s-500"></i>', $field->value ? $field->color : 'grey');
        }

        return $next($field);
    }
}
