<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Validates;

final class Rules
{
    /**
     * Set the validation rules for the field base on the current action
     */
    public function create(object $field, string $controllerAction): array
    {
        return array_merge(
            $this->currentRules($field, $controllerAction),
            $field->defaultRules ?? []
        );
    }

    /**
     * Get the current rules for each controller action
     * It is an helper for $this->createRules($field)
     */
    private function currentRules(object $field, string $controllerAction): array
    {
        $rules = [
            'create' => $field->creationRules ?? $field->rules ?? [],
            'edit' => $field->updateRules ?? $field->rules ?? [],
        ];

        return in_array($controllerAction, array_keys($rules))
            //Create or edit rules
            ? $rules[$controllerAction]
            // Default rules
            : $field->rules ?? [];
    }
}
