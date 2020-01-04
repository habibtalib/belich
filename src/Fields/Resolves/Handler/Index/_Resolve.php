<?php

namespace Daguilarm\Belich\Fields\Resolves\Handler\Index;

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
    public function handle(object $fields): object
    {
        // Resolve the fields
        $fields = $this->resolveFields($fields);

        return collect([
            // Resolve visibility for the fields (for the index view)
            'data' => app(FieldsVisibility::class)->handle($fields, function(){}),
        ]);
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
                    \Daguilarm\Belich\Fields\Resolves\Handler\Index\Values\Relationship::class,
                    // Resolve field color
                    \Daguilarm\Belich\Fields\Resolves\Handler\Index\Values\Color::class,
                ])
                ->thenReturn();
        });
    }
}
