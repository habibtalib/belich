<?php

namespace Daguilarm\Belich\Components;

use Illuminate\Support\Str;

trait Breadcrumbs {

    /*
    |--------------------------------------------------------------------------
    | Breadcrumbs
    |--------------------------------------------------------------------------
    */

    public static function breadcrumbs()
    {
        $resource = self::resource($withSqlConection = false);

        $items =  collect($resource['breadcrumbs'])
            ->map(function($item) {
                if($item['url']) {
                    return sprintf('<li nav-breadcrumbs-items><a href="%s" class="text-blue font-bold">%s</a></li>', $item['url'], $item['title']);
                }
                return sprintf('<li nav-breadcrumbs-items-current>%s</li>', $item['title']);
            })
            ->implode('<li class="separator"></li>');

        return sprintf('<nav class="nav-breadcrumbs"><ul class="nav-breadcrumbs-list">%s</ul></nav>', $items);
    }

    /**
     * Generate the breadcrumb
     *
     * @param object $resource
     * @return string
     */
    private static function filterBreadcrumbs($resource)
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
