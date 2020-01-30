<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Resolves\Handler\Index\Types;

use Closure;
use Daguilarm\Belich\Contracts\HandleField;
use Daguilarm\Belich\Fields\Traits\Resolvable;

final class TextAreaAndMarkdown implements HandleField
{
    use Resolvable;

    private ?string $value;

    public function __construct(?string $value)
    {
        $this->value = $value;
    }

    /**
     * Resolve textarea or markdown value
     */
    public function handle(object $field, Closure $next): object
    {
        //TextArea or markdown field
        if ($field->type === 'textArea' || $field->type === 'markdown') {
            $field->value = $this->resolveTextArea($field, $this->value);
        }

        return $next($field);
    }
}
