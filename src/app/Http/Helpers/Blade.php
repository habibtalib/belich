<?php

use Daguilarm\Belich\Components\Metrics\Graph;

/*
|--------------------------------------------------------------------------
| Helper for the blade Metrics. Components\metrics.blade.php
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
    function createFormSelectOptions($options, $field)
    {
        return collect($options)
            ->map(function($key, $value) use ($field) {
                //Default values
                $selected = Cookie::get('belich_' . $field) == $value ? ' selected' : '';
                $value = ($value === 0) ? $key : $value;
                $selected = (Cookie::get('belich_' . $field) == $value) ? ' ' . 'selected' : '';

                return sprintf('<option value="%s"%s>%s</option>', $value, $selected, $key);
            })
            ->implode('');
    }
}


