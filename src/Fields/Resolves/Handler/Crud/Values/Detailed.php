<?php

namespace Daguilarm\Belich\Fields\Resolves\Handler\Crud\Values;

use Closure;
use Daguilarm\Belich\Contracts\HandleField;
use Illuminate\Pipeline\Pipeline;

final class Detailed implements HandleField
{
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
     * @param string $action
     * @param object $sql
     */
    public function __construct(string $action, object $sql)
    {
        $this->action = $action;
        $this->sql = $sql;
    }

    /**
     * Handle the Show/Detailed view
     *
     * @param object $field
     * @param Closure $next
     *
     * @return object
     */
    public function handle(object $field, Closure $next): object
    {
        if ($this->action !== 'show') {
            return $next($field);
        }

        // Add filters to the pipeline for resolving Detailed view
        $field = app(Pipeline::class)
            ->send($field)
            ->through([
                // Resolve data attribute
                new \Daguilarm\Belich\Fields\Resolves\Handler\Crud\Values\Data($this->sql),
                // Resolve value for custom fields
                new \Daguilarm\Belich\Fields\Resolves\Handler\Types\Custom($this->sql),
                // Resolve value for select fields
                \Daguilarm\Belich\Fields\Resolves\Handler\Types\Select::class,
                // Resolve value for TextArea and Markdown
                \Daguilarm\Belich\Fields\Resolves\Handler\Types\TextArea::class,
                // Resolve value for color fields
                \Daguilarm\Belich\Fields\Resolves\Handler\Types\Color::class,
                // Resolve value for currency fields
                \Daguilarm\Belich\Fields\Resolves\Handler\Types\Currency::class,
                // Resolve value for boolean fields
                \Daguilarm\Belich\Fields\Resolves\Handler\Types\Boolean::class,
            ])
            ->thenReturn();

        return $next($field);
    }
}
