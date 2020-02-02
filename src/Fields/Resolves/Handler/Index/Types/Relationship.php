<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Resolves\Handler\Index\Types;

use Closure;
use Daguilarm\Belich\Contracts\HandleField;

final class Relationship implements HandleField
{
    private ?object $data;

    public function __construct(?object $data)
    {
        $this->data = $data;
    }

    /**
     * Resolve relationship or custom field value
     */
    public function handle(object $field, Closure $next): object
    {
        // Resolve for relationship or custom fields
        if ($this->condition($field)) {
            $field->value = $field->index($field, $this->data);
        }

        return $next($field);
    }

    /**
     * Check for condition
     */
    private function condition(object $field)
    {
        return $field->type === 'relationship' || $field->type === 'custom';
    }
}
