<?php

use Daguilarm\Belich\Components\Metrics\Graph;
use Daguilarm\Belich\Fields\Field;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Helper for the blade. Hide content base on screen size
|--------------------------------------------------------------------------
*/

/**
 * Hide content base on screen size
 *
 * @param object $hideFor
 * @return bool
 */
if (!function_exists('hideContainerForScreens')) {
    function hideContainerForScreens(array $hideFor)
    {
        $screens = collect(['sm', 'md', 'lg', 'xl']);

        return $screens
            ->map(function($size) use ($hideFor) {
                $status = in_array($size, $hideFor) ? 'hidden' : 'flex';
                return sprintf('%s:%s', $size, $status);
            })
            ->filter()
            ->prepend('hidden')
            ->implode(' ');
    }
}

/**
 * Hide cards base on screen size
 *
 * @param object $request
 * @return bool
 */
if (!function_exists('hideCardsForScreens')) {
    function hideCardsForScreens()
    {
        return hideContainerForScreens(config('belich.hideCardsForScreens'));
    }
}

/**
 * Hide metrics base on screen size
 *
 * @param object $request
 * @return bool
 */
if (!function_exists('hideMetricsForScreens')) {
    function hideMetricsForScreens()
    {
        return hideContainerForScreens(config('belich.hideMetricsForScreens'));
    }
}

/*
|--------------------------------------------------------------------------
| Helper for the blade Metrics. Components\metrics\legend.blade.php
|--------------------------------------------------------------------------
*/

/**
 * Determine if the view has a metric chart
 *
 * @param object $request
 * @return bool
 */
if (!function_exists('hasMetrics')) {
    function hasMetrics($request) : bool
    {
        return optional($request)->metrics
            ? count($request->metrics) > 0
            : false;
    }
}

/**
 * Determine if the view has a metric legend
 *
 * @param object $request
 * @return bool
 */
if (!function_exists('hasMetricsLegends')) {
    function hasMetricsLegends(object $request) : bool
    {
        return (($request->legend_h || $request->legend_v) && $request->type !== 'pie')
            ? true
            : false;
    }
}

/*
|--------------------------------------------------------------------------
| Helper for the blade Metrics. Components\metrics\chart.blade.php
|--------------------------------------------------------------------------
*/

/**
 * Set the color between the options, for the metrics in blade template
 *
 * @param Daguilarm\Belich\Components\Metrics\Graph $metric
 * @param string $type
 * @return string
 */
if (!function_exists('setColor')) {
    function setColor(Graph $metric, string $type) : string
    {
        return $metric->defineColor[$type] ?? $metric->color;
    }
}

/*
|--------------------------------------------------------------------------
| Helper for the blade directive @optionFromArray
|--------------------------------------------------------------------------
*/

/**
 * Set the default value for a empty string or result
 *
 * @return string
 */
if (!function_exists('createFormSelectOptions')) {
    function createFormSelectOptions($options, $field, $emptyField = false)
    {
        $cookie = Cookie::get('belich_' . $field);

        return collect($options)
            ->map(function($label, $value) use ($cookie, $field) {
                //Default values
                $defaultValue = !is_array($value) ? strtolower($label) : $value;
                $selected = ($cookie == $defaultValue || $cookie == $value)
                    ? ' ' . 'selected'
                    : '';

                return sprintf('<option value="%s"%s>%s</option>', $defaultValue, $selected, $label);
            })
            ->prepend($emptyField ? '<option></option>' : '')
            ->implode('');
    }
}

/*
|--------------------------------------------------------------------------
| Helper for the belich fields: ./resources/fields
|--------------------------------------------------------------------------
*/

/**
 * Render the field attribute base on the value
 *
 * @param Daguilarm\Belich\Fields\Field $field
 * @param string $attribute
 * @param mixed $default
 * @return string
 */
if (!function_exists('setAttribute')) {
    function setAttribute(Field $field, string $attribute, $default = null)
    {
        //Format attribute names for HTML5
        $filter = [
            'addClass' => 'class',
        ];

        //Render css classes
        if($attribute === 'addClass') {
            $field->addClass = !empty($field->addClass)
                ? implode(' ', $field->addClass)
                : '';
        }

        //Checked field
        if($attribute === 'checked') {
            return $field->value ? 'checked="checked"' : '';
        }

        //Apply the format
        $filterAttribute = str_replace(array_keys($filter), array_values($filter), $attribute);

        //Add classes
        if(isset($field->{$attribute}) && $attribute === 'addClass' && isset($default)) {
            $value = $field->{$attribute} . ', ' . $default;

        //Value or default value
        } else {
            $value = $field->{$attribute} ?? $default;
        }

        //Pattern mask
        if($filterAttribute === 'mask') {
            return sprintf('data-mask="%s"', $value);
        }

        return $value
            ? sprintf('%s="%s"', $filterAttribute, $value)
            : '';
    }
}

/**
 * Render the field attribute base on the value
 *
 * @param Daguilarm\Belich\Fields\Field $field
 * @param string $prefix
 * @return string
 */
if (!function_exists('renderWithPrefix')) {
    function renderWithPrefix(Field $field, string $prefix)
    {
        return collect(explode(' ', $field->render))->map(function($item) use ($prefix) {
            //Get the fields
            $item = explode('=', $item);
            //Prefixed dusk field
            if($item[0] === 'dusk') {
                $value = explode('-', $item[1]);
                //Format: dusk-$prefix-$attribute
                array_splice($value, 1, 0, $prefix);
                return [$item[0] => implode('-', $value)];
            }
            //Check for regular fields
            if(count($item) > 1) {
                return [$item[0] => implode('_', [$prefix, $item[1]])];
            }
            //Fields: readonly and disabled (this fields don't has an structure like: attribute=value)
            return $item[0];
        })
            ->map(function($value) {
                if(is_array($value)) {
                    return sprintf('%s=%s', array_keys($value)[0], array_values($value)[0]);
                }
                return $value;
            })
                ->implode(' ');
    }
}
