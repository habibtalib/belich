<?php

/*
|--------------------------------------------------------------------------
| Urls
|--------------------------------------------------------------------------
*/

/**
 * Get the url + parameters
 *
 * @param string $url
 * @return string
 */
if (!function_exists('urlBuilder')) {
    function urlBuilder($url = null)
    {
        $url = $url ?? url()->current();

        $query = collect(request()->query())
            ->map(function($value, $key) {
                return sprintf('%s=%s', $key, $value);
            })
            ->values()
            ->implode('&');

        return sprintf('%s/?%s', $url, $query);
    }
}
