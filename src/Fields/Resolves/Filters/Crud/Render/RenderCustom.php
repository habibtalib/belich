<?php

namespace Daguilarm\Belich\Fields\Resolves\Filters\Crud\Render;

use Closure;
use Illuminate\Support\Collection;

final class RenderCustom
{
    /**
     * Render custom attributes for a field
     *
     * @param object $field
     * @param Closure $next
     *
     * @return object
     */
    public function handle(object $field, Closure $next): object
    {
        // Get the attributes list
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

        return $next($field);
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
            'autocomplete' => $this->autocompleteAttribute($field),
            'autofocus' => $this->autofocusAttribute($field),
            'disabled' => $this->disabledAttribute($field),
            'data' => $this->dataAttribute($field),
            'maxlength' => $this->maxlengthAttribute($field),
            'max' => $this->maxAttribute($field),
            'min' => $this->minAttribute($field),
            'multiple' => $this->multipleAttribute($field),
            'placeholder' => $this->placeholderAttribute($field),
            'pattern' => $this->patternAttribute($field),
            'readonly' => $this->readonlyAttribute($field),
            'step' => $this->stepAttribute($field),
        ]);
    }

    /**
     * Render the autocomplete attribute
     *
     * @param object $field
     *
     * @return string
     */
    private function autocompleteAttribute(object $field): string
    {
        return $this->renderAttributes('autocomplete', $field);
    }

    /**
     * Render the autofocus attribute
     *
     * @param object $field
     *
     * @return string
     */
    private function autofocusAttribute(object $field): string
    {
        return 'autofocus';
    }

    /**
     * Render the disabled attribute
     *
     * @param object $field
     *
     * @return string
     */
    private function disabledAttribute(object $field): string
    {
        return 'disabled';
    }

    /**
     * Render the data attributes
     *
     * @param array $field
     *
     * @return string
     */
    private function dataAttribute($field): string
    {
        return collect($field->data)
            ->map(static function ($value) {
                return sprintf('data-%s="%s"', $value[0], $value[1]);
            })
            ->implode(' ');
    }

    /**
     * Render the maxlength attribute
     *
     * @param object $field
     *
     * @return string
     */
    private function maxlengthAttribute(object $field): string
    {
        return $this->renderAttributes('maxlength', $field);
    }

    /**
     * Render the max attribute
     *
     * @param object $field
     *
     * @return string
     */
    private function maxAttribute(object $field): string
    {
        return $this->renderAttributes('max', $field);
    }

    /**
     * Render the min attribute
     *
     * @param object $field
     *
     * @return string
     */
    private function minAttribute(object $field): string
    {
        return $this->renderAttributes('min', $field);
    }

    /**
     * Render the multiple attribute
     *
     * @param object $field
     *
     * @return string
     */
    private function multipleAttribute(object $field): string
    {
        return 'multiple';
    }

    /**
     * Render the placeholder attribute
     *
     * @param object $field
     *
     * @return string
     */
    private function placeholderAttribute(object $field): string
    {
        return $this->renderAttributes('placeholder', $field);
    }

    /**
     * Render the pattern attribute
     *
     * @param object $field
     *
     * @return string
     */
    private function patternAttribute(object $field): string
    {
        return $this->renderAttributes('pattern', $field);
    }

    /**
     * Render the readonly attribute
     *
     * @param object $field
     *
     * @return string
     */
    private function readonlyAttribute(object $field): string
    {
        return $field->type !== 'hidden'
            ? 'readonly'
            : '';
    }

    /**
     * Render the step attribute
     *
     * @param object $field
     *
     * @return string
     */
    private function stepAttribute(object $field): string
    {
        return $this->renderAttributes('step', $field);
    }

    /**
     * Render attributes for field
     *
     * @param string $attribute
     * @param object $field
     *
     * @return string
     */
    private function renderAttributes(string $attribute, object $field): string
    {
        return sprintf('%s="%s"', $attribute, $field->{$attribute} ?? null);
    }
}
