<?php

namespace Daguilarm\Belich\Fields\Resolves\Filters\Crud\Values;

use Closure;
use Daguilarm\Belich\Contracts\HandleField;

final class RelationshipActions implements HandleField {
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
     * Handle the relationship value
     *
     * @param object $field
     * @param Closure $next
     *
     * @return object
     */
    public function handle(object $field, Closure $next): object
    {
        if ($field->type === 'custom' && $this->action !== 'edit') {
            $field->value = $field->{$this->action}($field, $this->sql);
        }

        return $next($field);
    }
}
