<?php

namespace Daguilarm\Belich\Fields\Resolves\Handler\Crud;

use Daguilarm\Belich\Fields\Resolves\Handler\FieldsVisibility;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Collection;

final class _Resolve {

    /**
     * Resolve fields: auth, visibility, value,...
     *
     * @param object $fields
     *
     * @return Illuminate\Support\Collection
     */
    public function handle(object $fields, string $action, object $sql): object
    {
        // Add filters to the pipeline
        return app(Pipeline::class)
            ->send($fields)
            ->through([
                // Resolve visibility for fields
                \Daguilarm\Belich\Fields\Resolves\Handler\FieldsVisibility::class,
                // Render default attributes from:
                // Daguilarm\Belich\Fields\Traits\Renderable
                \Daguilarm\Belich\Fields\Resolves\Handler\Crud\_Render::class,
                //Resolve values for fields
                //Only for Edit or Show/Detailed actions
                new \Daguilarm\Belich\Fields\Resolves\Handler\Crud\_Values($action, $sql),
            ])
            ->thenReturn();
    }

    /**
     * Resolve fields
     *
     * @param object $fields
     *
     * @return Illuminate\Support\Collection
     */
    private function resolveFields(object $fields): Collection
    {
        return $fields->map(function ($field) {
            // Add filters to the pipeline
            return app(Pipeline::class)
                ->send($field)
                ->through([
                    // Resolve field relationship
                    \Daguilarm\Belich\Fields\Resolves\Handler\Index\ResolveRelationship::class,
                    // Resolve field color
                    \Daguilarm\Belich\Fields\Resolves\Handler\Index\ResolveColor::class,
                ])
                ->thenReturn();
        });
    }

    /**
     * Render each field value
     *
     * @param array $field
     *
     * @return object
     */
    private function render($field): object
    {
        $field->render = $field->render->implode(' ');

        return $field;
    }
}
