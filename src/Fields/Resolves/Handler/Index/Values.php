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
    private function resolveValue(object $field, ?object $data, ?string $value): ?string
    {
        //Resolve Relationship
        return isset($data) && ! $value
            ? $this->resolveRelationship($field, $data)
            : $value;
    }

    /**
     * Resolve field values for: relationship
     * This method is helper for $this->resolve()
     */
    private function resolveRelationship(object $field, ?object $data): ?string
    {
        // Set attribute
        $attribute = $field->attribute;

        if (is_array($attribute)) {
            //Resolve Relationship
            $relationship = optional($data)->{$attribute[0]};
            $value = optional($relationship)->{$attribute[1]};
        } else {
            //Resolve value for action controller: edit
            $value = optional($data)->{$attribute};
        }

        return $this->resolveToString($value);
    }

    /**
     * Resolve a string value
     *
     * @param string|int|null $value
     */
    private function resolveToString($value): string
    {
        return $value
            ? (string) $value
            : Helper::emptyResults();
    }
}
