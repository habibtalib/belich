<?php

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

        // Add filters to the pipeline
        $field = app(Pipeline::class)
            ->send($field)
            ->through([
                // Resolve relationship value
                new \Daguilarm\Belich\Fields\Resolves\Handler\Index\Types\Relationship($data),
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
            ])
            ->thenReturn();

        //Resolve the field value through callbacks
        return app(Callback::class)->handle($field, $data, $value);
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
