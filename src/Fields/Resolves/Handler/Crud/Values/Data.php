<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Resolves\Handler\Crud\Values;

use Closure;
use Daguilarm\Belich\Contracts\HandleField;

final class Data implements HandleField
{
    /**
     * @var string
     */
    private $sql;

    /**
     * Init constructor
     *
     * @param object $sql
     */
    public function __construct($sql)
    {
        $this->sql = $sql;
    }

    /**
     * Handle the data attribute
     *
     * @param object $field
     * @param Closure $next
     *
     * @return object
     */
    public function handle(object $field, Closure $next): object
    {
        // Resolve the data attribute
        $field->data = $this->sql;

        return $next($field);
    }
}
