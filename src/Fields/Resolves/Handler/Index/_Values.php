<?php

namespace Daguilarm\Belich\Fields\Resolves\Handler\Index;

use Daguilarm\Belich\Facades\Helper;
use Daguilarm\Belich\Fields\Resolves\Handler\Index\Values\Callback;
use Daguilarm\Belich\Fields\Resolves\Handler\Index\Values\File;
use Daguilarm\Belich\Fields\Traits\Resolvable;

final class _Values
{
    use Resolvable;

    /**
     * Resolve field values for: relationship, displayUsing and resolveUsing
     * This method is used throw Belich Facade => Belich::value($field, $data);
     * This method is for refactoring the blade templates.
     * For index view
     *
     * @param  object $field
     * @param  object $data
     * @param  string|null $value
     *
     * @return string|null
     */
    public function handle(object $field, ?object $data = null, ?string $value = null): ?string
    {
        //Resolve value for field
        //Keep in first position
        $value = $this->resolveValue($field, $data, $value);

        // Resolve for relationship fields
        if ($field->type === 'relationship' || $field->type === 'custom') {
            return $field->index($field, $data);
        }

        // If boolean
        if ($field->type === 'boolean') {
            return $this->resolveBoolean($field, $value);
        }

        //File field
        if ($field->type === 'file') {
            return app(File::class)->handle($field, $value);
        }

        //TextArea field
        if ($field->type === 'textArea' || $field->type === 'markdown') {
            return $this->resolveTextArea($field, $value);
        }

        //displayUsingLabels filter
        if (isset($field->displayUsingLabels) && $field->displayUsingLabels) {
            return Helper::displayUsingLabels($field, $value);
        }

        // Resolve show view for custom field
        if ($field->type === 'color' && isset($field->asColor) && $field->asColor === true) {
            // Set value
            return sprintf('<div class="w-12 h-2 rounded" style="background-color:%s">&nbsp;</div>', $value);
        }

        //Resolve the field value through callbacks
        return app(Callback::class)->handle($field, $data, $value);
    }

    private function HandleByType()
    {
        return [
            'custom' => 'handleRelationship',
            'relationship' => 'handleRelationship',
        ];
    }

    /**
     * Resolve field values for: relationship
     * This method is helper for $this->resolve()
     *
     * @param  object $field
     * @param object $data
     * @param  string|null $value
     *
     * @return string|null
     */
    private function resolveValue(object $field, ?object $data, ?string $value): ?string
    {
        //Resolve Relationship
        return isset($data)
            ? $this->resolveRelationship($field, $data)
            : $value;
    }

    /**
     * Resolve boolean fields
     * This method is helper for $this->resolve()
     *
     * @param  object $field
     * @param  mixed $value
     *
     * @return string|null
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

    /**
     * Resolve field values for: relationship
     * This method is helper for $this->resolve()
     *
     * @param  object $field
     * @param  object|null $data
     *
     * @return string|null
     */
    private function resolveRelationship(object $field, ?object $data): ?string
    {
        // Set attribute
        $attribute = $field->attribute;

        //Resolve Relationship
        if (is_array($attribute)) {
            $relationship = $data->{$attribute[0]};

            return optional($relationship)->{$attribute[1]} ?? Helper::emptyResults();
        }

        //Resolve value for action controller: edit
        return $data->{$attribute} ?? Helper::emptyResults();
    }
}
