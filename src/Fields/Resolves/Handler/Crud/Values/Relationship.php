<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Resolves\Handler\Crud\Values;

use Closure;
use Daguilarm\Belich\Contracts\HandleField;

final class Relationship implements HandleField
{
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
    public function __construct($sql)
    {
        $this->sql = $sql;
    }

    /**
     * Handle the relationship value
     *
     * @param object $field
     * @param Closure $next
     *
     * @return object
     */
    public function handle(object $field, Closure $next): object
    {
        // Add relationship values
        if ($field->fieldRelationship || $field->type === 'relationship') {
            [$field->valueRelationship, $field->value] = $this->valueRelationship($field);

            return $next($field);
        }

        return $next($field);
    }

    /**
     * Handle the values for the relationship
     *
     * @param object $field
     *
     * @return string
     */
    private function valueRelationship($field)
    {
        // Get parametters
        $fieldRelationship = $field->fieldRelationship;
        $attribute = $field->attribute;
        $sqlRelationship = optional($this->sql)->{$fieldRelationship};

        return [
            // Relationship ID
            optional($sqlRelationship)->id,
            // Relationship VALUE
            optional($sqlRelationship)->{$attribute},
        ];
    }
}
