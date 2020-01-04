<?php

namespace Daguilarm\Belich\Fields\Resolves\Handler\Crud;

use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Collection;

final class Resolve
{
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
                \Daguilarm\Belich\Fields\Resolves\Handler\Crud\Render::class,
                //Resolve values for fields
                //Only for Edit or Show/Detailed actions
                new \Daguilarm\Belich\Fields\Resolves\Handler\Crud\Values($action, $sql),
            ])
            ->thenReturn();
    }
}
