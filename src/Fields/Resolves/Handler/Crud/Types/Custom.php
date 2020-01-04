<?php

namespace Daguilarm\Belich\Fields\Resolves\Handler\Crud\Types;

use Closure;
use Daguilarm\Belich\Contracts\HandleField;

final class Custom implements HandleField
{
    /**
     * @var object
     */
    private $sql;

    /**
     * Init constructor
     *
     * @param object $sql
     */
    public function __construct(object $sql)
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
        // Resolve show view for custom field
        if ($field->type === 'custom') {
            // Set value
            $field->value = $field->show($field, $this->sql);
        }

        return $next($field);
    }
}
