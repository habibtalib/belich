<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Resolves\Handler\Index;

use Daguilarm\Belich\Facades\Helper;
use Daguilarm\Belich\Fields\Resolves\Handler\Index\Callback;
use Daguilarm\Belich\Fields\Traits\Resolvable;
use Illuminate\Pipeline\Pipeline;

final class Values
{
    use Resolvable;

    /**
     * Resolve field values for: relationship, displayUsing and resolveUsing
     * This method is used throw Belich Facade => Belich::value($field, $data);
     * This method is for refactoring the blade templates.
     * For index view
     *
     * @var string|object|null $value
     *
     * @return string|object|null
     */
    public function handle(object $field, ?object $data = null, ?string $value = null)
    {
        //Resolve value for field
        //Keep in first position
        $value = $this->resolveValue($field, $data, $value);

        // Add filters to the pipeline
        $field = app(Pipeline::class)
            ->send($field)
            ->through([
                // Resolve boolean value
                new \Daguilarm\Belich\Fields\Resolves\Handler\Index\Types\Boolean($value),
                // Resolve file value
                new \Daguilarm\Belich\Fields\Resolves\Handler\Index\Types\File($value),
                // Resolve textArea and markdown value
                new \Daguilarm\Belich\Fields\Resolves\Handler\Index\Types\TextAreaAndMarkdown($value),
                // Resolve select value (displayUsingLabels())
                new \Daguilarm\Belich\Fields\Resolves\Handler\Index\Types\Select($value),
                // Resolve color value
                new \Daguilarm\Belich\Fields\Resolves\Handler\Index\Types\Color($value),
                // Resolve relationship value
                new \Daguilarm\Belich\Fields\Resolves\Handler\Index\Types\Relationship($data),
            ])
            ->thenReturn();

        //Resolve the field value through callbacks
        return app(Callback::class)->handle($field, $data, $field->value ?? $value);
    }

    /**
     * Resolve field values for: relationship
     * This method is helper for $this->resolve()
     */
    private function resolveValue(object $field, ?object $data, ?string $value)
    {
        //Resolve Relationship
        return isset($data) && (is_null($value) || ! $value)
            ? $this->resolveValueFromData($field, $data)
            : $value;
    }

    /**
     * Resolve field values for: relationship and non relationship
     * This method is helper for $this->resolve()
     */
    private function resolveValueFromData(object $field, ?object $data)
    {
        // Set attribute
        $attribute = $field->attribute;

        //Resolve Relationship
        if (is_array($attribute)) {
            $relationship = optional($data)->{$attribute[0]};
            $value = optional($relationship)->{$attribute[1]};
        //Resolve value for non relationships
        } else {
            $value = optional($data)->{$attribute};
        }

        return $this->resolveToCast($field, $value);
    }

    /**
     * Resolve a string value
     *
     * @param string|bool|int|float|null $value
     */
    private function resolveToCast(object $field, $value)
    {
        return $field->type === 'boolean'
            ? $this->resolveAsBoolean($value)
            : $this->resolveAsString($value);
    }

    /**
     * Resolve as boolean
     *
     * @param string|bool|int|float|null $value
     */
    private function resolveAsBoolean($value): bool
    {
        return $value
            ? (bool) $value
            : (bool) 0;
    }

    /**
     * Resolve as string
     *
     * @param string|bool|int|float|null $value
     */
    private function resolveAsString($value): string
    {
        return $value
            ? (string) $value
            : Helper::emptyResults();
    }
}
