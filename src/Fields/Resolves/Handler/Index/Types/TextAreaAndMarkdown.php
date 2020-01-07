<?php

namespace Daguilarm\Belich\Fields\Resolves\Handler\Index\Types;

use Closure;
use Daguilarm\Belich\Contracts\HandleField;
use Daguilarm\Belich\Fields\Traits\Resolvable;

final class TextAreaAndMarkdown implements HandleField
{
    use Resolvable;

    /**
     * @var string|null
     */
    private $value;

    /**
     * Init constructor
     *
     * @param string|null $value
     */
    public function __construct(?string $value)
    {
        $this->value = $value;
    }

    /**
     * Resolve textarea or markdown value
     *
     * @param object $field
     * @param Closure $next
     *
     * @return object
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
