<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Resolves\Handler;

use Closure;

final class AuthorizeFields
{
    /**
     * Handle the fields authorization
     */
    public function handle($fields, Closure $next): ?object
    {
        return $fields->map(function ($field) {
            return $this->canSee($field)
                ? $field
                : null;
        })->filter();
    }

    /**
     * Determine if the user has been authorized to see the field: $field->canSee()
     */
    private function canSee(object $field): bool
    {
        return ! isset($field->seeCallback) || (is_callable($field->seeCallback) && call_user_func($field->seeCallback, request()) !== false);
    }
}
