<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Resolves\Handler\Crud;

use Closure;
use Daguilarm\Belich\Contracts\HandleField;
use Daguilarm\Belich\Facades\Belich;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Collection;

final class Render implements HandleField
{
    private string $action;

    public function __construct()
    {
        $this->action = Belich::action();
    }

    /**
     * Render custom attributes for a field
     */
    public function handle(object $fields, Closure $next): Collection
    {
        if ($this->action === 'create' || $this->action === 'edit') {
            $fields = $fields->map(static function ($field) {
                // Add filters to the pipeline
                return app(Pipeline::class)
                    ->send($field)
                    ->through([
                        // Render default attributes from:
                        // Daguilarm\Belich\Fields\Traits\Renderable
                        \Daguilarm\Belich\Fields\Resolves\Handler\Crud\Render\RenderDefault::class,
                        // Render custom attributes
                        \Daguilarm\Belich\Fields\Resolves\Handler\Crud\Render\RenderCustom::class,
                        // Prepare the rendered array
                        \Daguilarm\Belich\Fields\Resolves\Handler\Crud\Render\RenderFilter::class,
                    ])
                    ->thenReturn();
            });
        }

        return $next($fields);
    }
}
