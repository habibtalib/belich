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
            'create' => $this->getActionRules($field, $field->creationRules),
            'edit' => $this->getActionRules($field, $field->updateRules),
        ];

        return in_array($controllerAction, array_keys($rules))
            //Create or edit rules
            ? $rules[$controllerAction]
            // Default rules
            : $field->rules ?? [];
    }

    /**
     * Get the action rules or the normal rules
     */
    private function getActionRules(object $field, array $actionRules)
    {
        return count($actionRules) > 0
            ? $actionRules
            : $field->rules;
    }
}
