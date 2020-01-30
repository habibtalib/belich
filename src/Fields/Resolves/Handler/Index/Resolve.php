<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Resolves\Handler\Index;

use Daguilarm\Belich\Fields\Resolves\Handler\FieldsVisibility;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Collection;

final class Resolve
{
    /**
     * Resolve fields: auth, visibility, value,...
     */
    public function handle(object $fields): object
    {
        // Resolve the fields
        $fields = $this->resolveFields($fields);

        return collect([
            // Resolve visibility for the fields (for the index view)
            'data' => app(FieldsVisibility::class)->handle($fields, static function (): void {
            }),
        ]);
    }

    /**
     * Resolve fields
     */
    private function resolveFields(object $fields): Collection
    {
        return $fields->map(static function ($field) {
            // Add filters to the pipeline
            return app(Pipeline::class)
                ->send($field)
                ->through([
                    // Resolve field relationship
                    \Daguilarm\Belich\Fields\Resolves\Handler\Index\Resolve\Attribute::class,
                    // Resolve field color
                    \Daguilarm\Belich\Fields\Resolves\Handler\Index\Resolve\Color::class,
                ])
                ->thenReturn();
        });
    }
}
