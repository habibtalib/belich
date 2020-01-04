<?php

namespace Daguilarm\Belich\Fields\Resolves\Handler\Types;

use Closure;
use Daguilarm\Belich\Contracts\HandleField;

final class Custom implements HandleField {
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
        // Resolve show view for custom field
        if ($field->type === 'custom') {
            // Set value
            $field->value = $field->show($field, $this->sql);
        }

        return $next($field);
    }
}
