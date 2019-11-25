<?php

namespace Daguilarm\Belich\Fields\Validates;

use Illuminate\Support\Collection;

final class Form
{
    /**
     * Set javascript form values.
     * Just completing the javascript code with the vales from the form fields
     *
     * @param Illuminate\Support\Collection $values
     *
     * @return string
     */
    public function values(Collection $values): string
    {
        return collect($values)
            ->map(static function ($value, $attribute) {
                if (isset($value) && isset($attribute)) {
                    return sprintf("%s:document.getElementById('%s').value", $attribute, $attribute);
                }
            })
            ->filter()
            ->implode(',');
    }

    /**
     * Set form validation rules
     * Generate an array with the validation rules for each field
     *
     * @param Illuminate\Support\Collection $values
     *
     * @return string
     */
    public function rules(Collection $values): string
    {
        return collect($values)
            ->map(static function ($value) {
                //Get the current rule
                return collect($value)->last();
            })
            //Remove the empty rules
            ->filter();
    }

    /**
     * Set form validation attributes
     * This is helpful for project with localization
     *
     * @param Illuminate\Support\Collection $values
     *
     * @return string|json
     */
    public function attributes(Collection $values): string
    {
        return collect($values)
            ->map(static function ($attribute) {
                return collect($attribute)->first();
            });
    }
}
