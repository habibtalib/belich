<?php

namespace Daguilarm\Belich\Fields\Resolves\Handler\Index\Types;

use Closure;
use Daguilarm\Belich\Contracts\HandleField;

final class Relationship implements HandleField
{
    /**
     * @var object|null
     */
    private $data;

    /**
     * Init constructor
     *
     * @param object $data
     */
    public function __construct(?object $data)
    {
        $this->data = $data;
    }

    /**
     * Resolve relationship or custom field value
     *
     * @param object $field
     * @param Closure $next
     *
     * @return object
     */
    public function handle(object $field, Closure $next): object
    {
        // Resolve for relationship or custom fields
        if ($field->type === 'relationship' || $field->type === 'custom') {
            $field->value = $field->index($field, $this->data);
        }

        return $next($field);
    }
}
