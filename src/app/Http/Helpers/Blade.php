<?php

use Daguilarm\Belich\Components\Metrics\Graph;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Helper for the blade. Hide content base on screen size
|--------------------------------------------------------------------------
*/

/**
 * Hide content base on screen size
 *
 * @param object $request
 * @return bool
 */
if (!function_exists('hideMetricsForScreens')) {
    function hideMetricsForScreens(object $request)
    {
        $values  = optional($request)->hideMetricsForScreens ?? config('belich.hideMetricsForScreens') ?? null;
        $screens = ['sm', 'md', 'lg', 'xl'];

        if(!empty($values) && is_array($values)) {
            return collect($screens)
                ->map(function($size) use ($values) {
                    $status = in_array($size, $values) ? 'hidden' : 'block';
                    return sprintf('%s:%s', $size, $status);
                })
                ->filter()
                ->prepend('hidden')
                ->implode(' ');
        }
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
if (!function_exists('hasMetric')) {
    function hasMetric($request) : bool
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
        return collect($options)
            ->map(function($key, $value) use ($field) {
                //Default values
                $selected = Cookie::get('belich_' . $field) == $value ? ' selected' : '';
                $value = ($value === 0) ? $key : $value;
                $selected = (Cookie::get('belich_' . $field) == $value) ? ' ' . 'selected' : '';

                return sprintf('<option value="%s"%s>%s</option>', $value, $selected, $key);
            })
            ->prepend($emptyField ? '<option></option>' : '')
            ->implode('');
    }
}


