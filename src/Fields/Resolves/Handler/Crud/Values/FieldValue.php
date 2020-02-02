<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Resolves\Handler\Crud\Values;

use Closure;
use Daguilarm\Belich\Contracts\HandleField;

final class FieldValue implements HandleField
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
        if ($field->type !== 'relationship') {
            $field->value = optional($this->sql)->{$field->attribute};
        }

        return $next($field);
    }
}
