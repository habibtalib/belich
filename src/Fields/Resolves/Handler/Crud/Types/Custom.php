<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Resolves\Handler\Crud\Types;

use Closure;
use Daguilarm\Belich\Contracts\HandleField;

final class Custom implements HandleField
{
    private object $sql;

    public function __construct(object $sql)
    {
        $this->sql = $sql;
    }

    /**
     * Handle the relationship value
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
