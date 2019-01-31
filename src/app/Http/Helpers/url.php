<?php

/*
|--------------------------------------------------------------------------
| Urls
|--------------------------------------------------------------------------
*/

/**
 * Get the url + parameters
 *
 * @param array $urlParameters
 * @return string
 */
if (!function_exists('urlBuilder')) {
    function urlBuilder($urlParameters = null)
    {
        $urlParameters = collect($urlParameters ?? request()->query())
            ->map(function($value, $key) {
                return sprintf('%s=%s', $key, $value);
            })
            ->values()
            ->implode('&');

        return sprintf('%s/?%s', url()->current(), $urlParameters);
    }
}

/**
 * Get the url + parameters
 *
 * @param Daguilarm\Belich\Fields\Field $field
 * @return string
 */
if (!function_exists('urlBuilderForTableHead')) {
    function urlBuilderForTableHead($field)
    {
        //Filter if attribute is a relationship or is not sortable
        if(is_array($field->attribute) || $field->sortable === false) {
            return $field->label;
        }

        //Get url parameters
        $urlParameters = request()->query();

        //Get order
        if(isset($urlParameters['direction']) && $urlParameters['direction'] === 'DESC') {
            $urlParameters = array_merge($urlParameters, [
                'order'     => $field->attribute,
                'direction' => 'ASC'
            ]);
        } else {
            $urlParameters = array_merge($urlParameters, [
                'order'     => $field->attribute,
                'direction' => 'DESC'
            ]);
        }

        return sprintf('<a href="%s">%s</a>', urlBuilder($urlParameters), $field->label);
    }
}
