<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Resolves\Handler\Index\Types;

use Closure;
use Daguilarm\Belich\Contracts\HandleField;

final class Boolean implements HandleField
{
    private ?string $value;

    public function __construct(?string $value)
    {
        $this->value = $value;
    }

    /**
     * Resolve boolean value
     */
    public function handle(object $field, Closure $next): object
    {
        if ($field->type === 'boolean') {
            $field->value = $this->resolveBoolean($field, $this->value);
        }

        return $next($field);
    }

    /**
     * Resolve boolean fields
     * This method is helper for $this->resolve()
     */
    private function resolveBoolean(object $field, $value): ?string
    {
        // With default labels
        if (isset($field->trueValue) && isset($field->falseValue)) {
            return $value
                ? $field->trueValue
                : $field->falseValue;
        }

        // With color circles
        return sprintf('<i class="fas fa-circle text-%s-500"></i>', $value ? $field->color : 'grey');
    }
}
