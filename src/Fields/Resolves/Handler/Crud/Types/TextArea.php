<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Resolves\Handler\Crud\Types;

use Closure;
use Daguilarm\Belich\Contracts\HandleField;
use Daguilarm\Belich\Fields\Traits\Resolvable;

final class TextArea implements HandleField
{
    use Resolvable;

    /**
     * Handle the relationship value
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
