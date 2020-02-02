<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Resolves\Handler\Index\Types;

use Closure;
use Daguilarm\Belich\Contracts\HandleField;

final class Boolean implements HandleField
{
    private string $disabledColor = 'gray';
    private $value;

    public function __construct($value)
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
     *
     * @param string|bool|int|float|null $value
     */
    private function resolveBoolean(object $field, $value): ?string
    {
        // With default labels
        if ($this->condition($field)) {
            return $value
                ? $field->trueValue
                : $field->falseValue;
        }

        // With color circles
        return sprintf(
            '<i class="fas fa-circle text-%s-500"></i>',
            $this->resolveColor($field->color, $value)
        );
    }

    /**
     * Check for condition
     */
    private function condition(object $field)
    {
        return isset($field->trueValue) && isset($field->falseValue);
    }

    /**
     * Resolve boolean color
     */
    private function resolveColor(string $color, bool $value)
    {
        return $value ? $color : $this->disabledColor;
    }
}
