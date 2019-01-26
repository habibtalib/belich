<?php

namespace Daguilarm\Belich\Components;

use Illuminate\Support\Str;

trait Breadcrumbs {

    /*
    |--------------------------------------------------------------------------
    | Breadcrumbs
    |--------------------------------------------------------------------------
    */

    /**
     * Generate the breadcrumb
     *
     * @return string
     */
    public function breadcrumbs()
    {
        $resource = $this->resource($withSqlConection = false);

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
     * Filter the breadcrumb
     *
     * @param object $resource
     * @return string
     */
    private function filterBreadcrumbs()
    {
        if(empty($this->breadcrumbs())) {
            $breadcrumbs = [
                trans('belich::belich.navigation.home') => self::url(),
                trans('belich::belich.actions.' . self::routeAction()) . ' ' . self::currentLabel($resource),
            ];
        }

        return collect($breadcrumbs)
            ->flip()
            ->map(function($title, $url) {
                return $this->breadcrumbsFilter($title, $url);
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
    private function breadcrumbsFilter($title, $url)
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
