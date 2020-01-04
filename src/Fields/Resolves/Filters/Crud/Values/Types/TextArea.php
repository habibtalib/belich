<?php

namespace Daguilarm\Belich\Fields\Resolves\Filters\Crud\Values\Types;

use Closure;
use Daguilarm\Belich\Contracts\HandleField;
use Daguilarm\Belich\Facades\Helper;
use Daguilarm\Belich\Fields\Traits\Resolvable;

final class TextArea implements HandleField {

    use Resolvable;

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
        //Resolve value for TextArea or Markdown
        if ($field->type === 'textArea' || $field->type === 'markdown') {
            $field->value = $this->resolveTextArea($field);
        }

        return $next($field);
    }
}
