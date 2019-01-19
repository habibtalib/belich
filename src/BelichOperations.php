<?php

namespace Daguilarm\Belich;

use Illuminate\Support\Str;

trait BelichOperations {

    /*
    |--------------------------------------------------------------------------
    | Breadcrumbs
    |--------------------------------------------------------------------------
    */

    /**
     * Generate the breadcrumb
     *
     * @param object $resource
     * @return string
     */
    public static function breadcrumbs($resource)
    {
        //Default values
        $breadcrumbs = $resource::$breadcrumbs;

        if(empty($breadcrumbs)) {
            $breadcrumbs = [
                trans('belich::belich.navigation.home') => self::url(),
                trans('belich::belich.actions.' . self::routeAction()) . ' ' . self::currentLabel($resource),
            ];
        }

        return collect($breadcrumbs)
            ->flip()
            ->map(function($title, $url) {
                return self::breadcrumbsFilter($title, $url);
            })
            ->values()
            ->toArray();
    }

    /**
     * Populate the breadcrumb
     *
     * @param object $resource
     * @return string
     */
    private static function breadcrumbsFilter($title, $url)
    {
        //current item
        if(empty($title)) {
            list($title, $url) = [$url, null];
        }

        //List items
        return [
            'title' => $title,
            'url'   => $url,
        ];
    }
}
