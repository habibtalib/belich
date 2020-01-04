<?php

namespace Daguilarm\Belich\Fields\Resolves\Handler;

use Closure;

final class AuthorizeFields {

    /**
     * Handle the fields authorization
     *
     * @param object $fields
     * @param Closure $next
     *
     * @return Illuminate\Support\Collection
     */
    public function handle($fields, Closure $next)
    {
        return $fields->map(function ($field) {
            return $this->canSee($field)
                ? $field
                : null;
        })->filter();
    }

    /**
     * Determine if the user has been authorized to see the field: $field->canSee()
     *
     * @param  object  $field
     *
     * @return bool
     */
    private function canSee(object $field)
    {
        return ! isset($field->seeCallback) || (is_callable($field->seeCallback) && call_user_func($field->seeCallback, request()) !== false);
    }
}

