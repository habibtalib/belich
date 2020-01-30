<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Resolves\Handler\Crud\Types;

use Closure;
use Daguilarm\Belich\Contracts\HandleField;

final class Boolean implements HandleField
{
    /**
     * Handle color field
     */
    public function handle(object $field, Closure $next): object
    {
        if ($field->type !== 'boolean') {
            return $next($field);
        }

        // Resolve boolean value
        $field->value = isset($field->trueValue) && isset($field->falseValue)
            ? $this->fieldValue($field)
            : sprintf('<i class="fas fa-circle text-%s-500"></i>', $field->value ? $field->color : 'grey');

        return $next($field);
    }

    /**
     * Handle field value
     */
    private function fieldValue($field): string
    {
        return $field->value
            ? $field->trueValue
            : $field->falseValue;
    }
}
