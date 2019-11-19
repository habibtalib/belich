<?php

namespace Daguilarm\Belich\Fields\Traits\Constructable;

use Illuminate\Support\Collection;

trait Renderable
{
    /**
     * Render default attributes from list
     *
     * @param array $field
     *
     * @return Illuminate\Support\Collection
     */
    protected function renderFieldAttributes($field): Collection
    {
        // Render attributes from default list. This are render in all the fields
        collect($field)
            ->each(static function ($value, $attribute) use ($field): void {
                //Get the list of attributes to be rendered: name, dusk,... and remove the attributes from the removed list
                $field->render[] = in_array($attribute, $field->renderAttributes) && ! in_array($attribute, $field->removedAttr)
                    ? sprintf('%s="%s"', $attribute, $value)
                    : null;
            })
            ->filter();

        // Render custom (special) attributes. Only if exists.
        $this->renderFieldCustomAttributes($field);

        return collect($field->render);
    }

    /**
     * Render custom attributes for field
     *
     * @param array $field
     *
     * @return void
     */
    protected function renderFieldCustomAttributes($field): void
    {
        // Set custom attributes
        $customAttributes = collect([
            'autofocus' => 'autofocus',
            'disabled' => 'disabled',
            'data' => $this->renderFieldAttributesData($field),
            'max' => sprintf('max="%s"', $field->max ?? null),
            'min' => sprintf('min="%s"', $field->min ?? null),
            'multiple' => 'multiple',
            'placeholder' => sprintf('placeholder="%s"', $field->placeholder),
            'pattern' => sprintf('pattern="%s"', $field->pattern ?? null),
            'step' => sprintf('step="%s"', $field->step ?? null),
        ]);

        $keys = $customAttributes->keys();

        $keys->filter(static function ($key) use ($customAttributes, $field) {
            //Only if the attribute exists
            return isset($field->{$key}) && $field->{$key} && $customAttributes[$key];
        })->each(static function ($key) use ($customAttributes, $field): void {
            // Add the custom attribute
            $field->render[] = $customAttributes[$key];
        });
    }

    /**
     * Render each field value
     *
     * @param array $field
     *
     * @return object
     */
    protected function renderField($field): object
    {
        $field->render = $field->render->implode(' ');

        return $field;
    }

    /**
     * Render data attributes for field
     *
     * @param array $field
     *
     * @return string
     */
    protected function renderFieldAttributesData($field): string
    {
        return collect($field->data)
            ->map(static function ($value) {
                return sprintf('data-%s="%s"', $value[0], $value[1]);
            })
            ->implode(' ');
    }
}
