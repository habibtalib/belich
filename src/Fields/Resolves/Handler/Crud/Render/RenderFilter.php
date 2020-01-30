<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Resolves\Handler\Crud\Render;

use Closure;

final class RenderFilter
{
    /**
     * Render default attributes for a field
     */
    public function handle(object $field, Closure $next): object
    {
        // Render attributes from default list. This are render in all the fields
        $field->render = $this->getAttributes($field);

        return $next($field);
    }

    /**
     * Render all the attributes from an array or a string
     */
    private function getAttributes(object $field): ?string
    {
        if (is_array($field->render)) {
            return collect($field->render)
                ->filter()
                ->implode(' ');
        }

        return $field->render;
    }
}
