<?php

namespace Daguilarm\Belich\Fields\Resolves\Handler\Crud;

use Closure;
use Daguilarm\Belich\Contracts\HandleField;
use Illuminate\Pipeline\Pipeline;

final class Values implements HandleField
{
    /**
     * @var string
     */
    private $action;

    /**
     * @var string
     */
    private $sql;

    /**
     * Init constructor
     *
     * @param object $sql
     * @param string $action
     */
    public function __construct($action, $sql)
    {
        $this->action = $action;
        $this->sql = $sql;
    }

    /**
     * Render custom attributes for a field
     *
     * @param object $field
     * @param Closure $next
     *
     * @return object
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
