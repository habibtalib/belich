<?php

namespace Daguilarm\Belich\Fields\Resolves\Filters\Crud;

use Closure;
use Daguilarm\Belich\Contracts\HandleField;
use Daguilarm\Belich\Facades\Belich;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Collection;

final class _Render implements HandleField
{
    /**
     * @var string
     */
    private $action;

    /**
     * Init constructor
     *
     * @param object $sql
     * @param string $action
     *
     * @return Illuminate\Support\Collection
     */
    public function __construct()
    {
        $this->action = Belich::action();
    }

    /**
     * Render custom attributes for a field
     *
     * @param object $field
     * @param Closure $next
     *
     * @return Illuminate\Support\Collection
     */
    public function handle(object $fields, Closure $next): Collection
    {
        if ($this->action === 'create' || $this->action === 'edit') {
            $fields = $fields->map(function ($field) {
                // Add filters to the pipeline
                return app(Pipeline::class)
                    ->send($field)
                    ->through([
                        // Render default attributes from:
                        // Daguilarm\Belich\Fields\Traits\Renderable
                        \Daguilarm\Belich\Fields\Resolves\Filters\Crud\Render\RenderDefault::class,
                        // Render custom attributes
                        \Daguilarm\Belich\Fields\Resolves\Filters\Crud\Render\RenderCustom::class,
                        // Prepare the rendered array
                        \Daguilarm\Belich\Fields\Resolves\Filters\Crud\Render\RenderFilter::class,
                    ])
                    ->thenReturn();
            });
        }

        return $next($fields);
    }
}
