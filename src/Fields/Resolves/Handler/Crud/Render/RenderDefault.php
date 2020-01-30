<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Resolves\Handler\Crud\Render;

use Closure;

final class RenderDefault
{
    /**
     * Render default attributes for a field
     */
    public function handle(object $field, Closure $next): object
    {
        // Render attributes from default list. This are render in all the fields
        collect($field)
            ->each(function ($value, $attribute) use ($field): void {
                //Get the list of attributes to be rendered: name, dusk,... and remove the attributes from the removed list
                $field->render[] = $this->render($field, $attribute, $value);
            })
            ->filter();

        return $next($field);
    }

    /**
     * Render default attributes
     */
    private function render(object $field, string $attribute, $value): ?string
    {
        return in_array($attribute, $field->renderAttributes) && ! in_array($attribute, $field->removedAttr)
            ? sprintf('%s="%s"', $attribute, $value)
            : null;
    }
}
