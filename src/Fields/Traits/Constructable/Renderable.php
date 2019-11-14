<?php

namespace Daguilarm\Belich\Fields\Traits\Constructable;

use Daguilarm\Belich\Fields\Field;
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
    protected function setRenderFieldAttributes($field): Collection
    {
        // Render attributes from default list. This are render in all the fields
        collect($field)
            ->each(static function ($value, $attribute) use ($field): void {
                //Get the list of attributes to be rendered: name, dusk,... and remove the attributes from the removed list
                $field->render[] = in_array($attribute, $field->renderAttributes) && ! in_array($attribute, $field->removedAttr)
                    ? sprintf('%s=%s', $attribute, $value)
                    : null;
            })
            ->filter();

        // Render custom (special) attributes. Only if exists.
        $this->setRenderFieldCustomAttributes($field);

        return collect($field->render);
    }

    /**
     * Render custom attributes for field
     *
     * @param array $field
     *
     * @return void
     */
    protected function setRenderFieldCustomAttributes($field): void
    {
        // Set custom attributes
        $customAttributes = collect([
            'autofocus' => 'autofocus',
            'disabled' => 'disabled',
            'data' => $this->setRenderFieldAttributesData($field),
            'multiple' => 'multiple',
            'placeholder' => sprintf('placeholder="%s"', $field->placeholder),
            'pattern' => sprintf('pattern="%s"', $field->pattern),
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
     * @return Daguilarm\Belich\Fields\Field
     */
    protected function renderField($field): Field
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
    protected function setRenderFieldAttributesData($field): string
    {
        return collect($field->data)
            ->map(static function ($value) {
                return sprintf('data-%s=%s', $value[0], $value[1]);
            })
            ->implode(' ');
    }
}
