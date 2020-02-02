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
        $field->value = $this->condition($field)
            ? $this->fieldValue($field)
            : $this->fieldValueRender($field);

        return $next($field);
    }

    /**
     * Field value condition
     */
    private function condition(object $field): string
    {
        return isset($field->trueValue) && isset($field->falseValue);
    }

    /**
     * Handle field value
     */
    private function fieldValue(object $field): string
    {
        return $field->value ? $field->trueValue : $field->falseValue;
    }

    /**
     * Render the field value
     */
    private function fieldValueRender(object $field): string
    {
        return sprintf(
            '<i class="fas fa-circle text-%s-500"></i>',
            $this->fieldValueRenderColor($field)
        );
    }

    /**
     * Render the field value color
     */
    private function fieldValueRenderColor(object $field): string
    {
        return $field->value ? $field->color : 'grey';
    }
}
