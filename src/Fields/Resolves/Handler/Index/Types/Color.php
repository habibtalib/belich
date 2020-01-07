<?php

namespace Daguilarm\Belich\Fields\Resolves\Handler\Index\Types;

use Closure;
use Daguilarm\Belich\Contracts\HandleField;

final class Color implements HandleField
{
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
     * Resolve color value
     *
     * @param object $field
     * @param Closure $next
     *
     * @return object
     */
    public function handle(object $field, Closure $next): object
    {
        // Resolve show view for custom field
        if ($field->type === 'color' && isset($field->asColor) && $field->asColor === true) {
            // Set value
            $field->value = sprintf('<div class="w-12 h-2 rounded" style="background-color:%s">&nbsp;</div>', $this->value);
        }

        return $next($field);
    }
}
