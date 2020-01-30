<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Resolves\Handler\Crud;

use Closure;
use Daguilarm\Belich\Contracts\HandleField;
use Illuminate\Pipeline\Pipeline;

final class Values implements HandleField
{
    private string $action;
    private object $sql;

    public function __construct($action, $sql)
    {
        $this->action = $action;
        $this->sql = $sql;
    }

    /**
     * Resolve values
     */
    public function handle(object $fields, Closure $next): object
    {
        //Resolve values for fields: Only for Edit or Show actions
        if ($this->action === 'edit' || $this->action === 'show') {
            // Filter by field
            return $fields->map(function ($field) {
                // Add filters to the pipeline
                return app(Pipeline::class)
                    ->send($field)
                    ->through([
                        // Resolve values
                        new \Daguilarm\Belich\Fields\Resolves\Handler\Crud\Values\FieldValue($this->sql),
                        // Resolve value for relationships
                        new \Daguilarm\Belich\Fields\Resolves\Handler\Crud\Values\Relationship($this->sql),
                        // Resolve field for relationships base on the actions
                        new \Daguilarm\Belich\Fields\Resolves\Handler\Crud\Values\RelationshipActions($this->action, $this->sql),
                        // Resolve field for Show/Detailed
                        new \Daguilarm\Belich\Fields\Resolves\Handler\Crud\Values\Detailed($this->action, $this->sql),
                    ])
                    ->thenReturn();
            });
        }

        return $next($fields);
    }
}
