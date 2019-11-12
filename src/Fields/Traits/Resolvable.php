<?php

namespace Daguilarm\Belich\Fields\Traits;

use Daguilarm\Belich\Facades\Belich;
use Daguilarm\Belich\Fields\Field;

trait Resolvable
{
    /**
     * Resolve select field using labels
     * This method is helper for $this->resolve()
     *
     * @param  Daguilarm\Belich\Fields\Field $field
     * @param  string|null $value
     *
     * @return string|null
     */
    public function displayUsingLabels(Field $field, ?string $value): ?string
    {
        return $field->options[$value] ?? $field->value ?? null;
    }

    /**
     * Resolve select field using labels
     * This method is helper for $this->resolve()
     *
     * @param  Daguilarm\Belich\Fields\Field $field
     * @param  string|null $value
     *
     * @return string|null
     */
    public function resolveTextArea(Field $field, ?string $value = null): ?string
    {
        // Default value
        $value = $value ?? $field->value;
        $shortValue = mb_strimwidth($value, 0, config('belich.textAreaChars'), '...');

        // Index and show resolve
        if((Belich::action() === 'index' && $field->fullTextOnIndex) || (Belich::action() === 'show' && $field->fullTextOnShow)) {
            return $value;
        }

        return $field->fullText
            ? $value
            : $shortValue;
    }
}
