<?php

namespace Daguilarm\Belich\Fields\Resolves;

use Illuminate\Support\Collection;

final class Render
{
    /**
     * Render default attributes from list
     *
     * @param array $field
     *
     * @return Illuminate\Support\Collection
     */
    public function execute($field): Collection
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
        $this->getAttributes($field);

        // Render relationship editable fields
        $this->getRelationshipEditable($field);

        return collect($field->render);
    }

    /**
     * Render custom attributes for field
     *
     * @param array $field
     *
     * @return void
     */
    private function getAttributes($field): void
    {
        $attributes = $this->prepareAttributes($field);

        // Populate with the attributes
        collect($attributes->keys())
            ->filter(static function ($key) use ($attributes, $field) {
                //Only if the attribute exists
                return isset($field->{$key}) && $field->{$key} && $attributes[$key];
            })->each(static function ($key) use ($attributes, $field): void {
                // Add the custom attribute
                $field->render[] = $attributes[$key];
            });
    }

    /**
     * Set the custom attributes for field
     *
     * @param array $field
     *
     * @return Collect
     */
    private function prepareAttributes($field): Collection
    {
        // Set custom attributes
        return collect([
            'autocomplete' => $this->renderAttributes('autocomplete', $field),
            'autofocus' => 'autofocus',
            'disabled' => 'disabled',
            'multiple' => 'multiple',
            'data' => $this->dataAttributes($field),
            'maxlength' => $this->renderAttributes('maxlength', $field),
            'max' => $this->renderAttributes('max', $field),
            'min' => $this->renderAttributes('min', $field),
            'placeholder' => $this->renderAttributes('placeholder', $field),
            'pattern' => $this->renderAttributes('pattern', $field),
            'step' => $this->renderAttributes('step', $field),
        ]);
    }

    /**
     * Render data attributes for field
     *
     * @param array $field
     *
     * @return string
     */
    private function dataAttributes($field): string
    {
        return collect($field->data)
            ->map(static function ($value) {
                return sprintf('data-%s="%s"', $value[0], $value[1]);
            })
            ->implode(' ');
    }

    /**
     * Render attributes for field
     *
     * @param string $attribute
     * @param $value
     *
     * @return string
     */
    private function renderAttributes(string $attribute, $value): string
    {
        return sprintf('%s="%s"', $attribute, $value->{$attribute} ?? null);
    }

    /**
     * Render attributes for field
     *
     * @param array $field
     *
     * @return void
     */
    private function getRelationshipEditable($field): void
    {
        if (isset($field->editableRelationship) && $field->editableRelationship === false && $field->editableRelationship === false) {
            $field->render[] = 'disabled="disabled"';
        }
    }
}
