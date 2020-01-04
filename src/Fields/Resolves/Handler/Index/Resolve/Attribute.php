<?php

namespace Daguilarm\Belich\Fields\Resolves\Handler\Index\Resolve;

use Closure;
use Daguilarm\Belich\Contracts\HandleField;

final class Attribute implements HandleField
{
    /**
     * Resolve fields attribute
     *
     * @param object $field
     * @param Closure $next
     *
     * @return object
     */
    public function handle(object $field, Closure $next): object
    {
        //Showing field relationship in index
        //See blade template: dashboard.index
        $field->attribute = $field->fieldRelationship
            //Prepare field for relationship
            ? [$field->fieldRelationship, $field->attribute]
            //No relationship field
            : $field->attribute;

        return $next($field);
    }
}
