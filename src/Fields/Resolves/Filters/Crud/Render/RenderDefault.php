<?php

namespace Daguilarm\Belich\Fields\Resolves\Filters\Crud\Render;

use Closure;

final class RenderDefault
{
    /**
     * Render default attributes for a field
     *
     * @param object $field
     * @param Closure $next
     *
     * @return object
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
     *
     * @param object $field
     * @param string $attribute
     * @param $value
     *
     * @return string|null
     */
    private function render(object $field, string $attribute, $value): ?string
    {
        return in_array($attribute, $field->renderAttributes) && ! in_array($attribute, $field->removedAttr)
            ? sprintf('%s="%s"', $attribute, $value)
            : null;
    }
}
