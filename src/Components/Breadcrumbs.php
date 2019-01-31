<?php

namespace Daguilarm\Belich\Components;

use Daguilarm\Belich\Core\Helpers;
use Html;

class Breadcrumbs {

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
    public static function make($resource)
    {
        $breadcrumbs = static::createBreadcrumbs($resource);

        $items =  collect($breadcrumbs)
            ->map(function($item) {
                if(!is_null($item['url'])) {
                    return sprintf('<li nav-breadcrumbs-items><a href="%s" class="text-blue font-bold">%s</a></li>', $item['url'], $item['title']);
                }
                return sprintf('<li nav-breadcrumbs-items-current>%s</li>', $item['title']);
            })
            ->implode('<li class="separator"></li>');

        return sprintf('<nav class="nav-breadcrumbs"><ul class="nav-breadcrumbs-list">%s</ul></nav>', $items);
    }

    /**
     * Create the breadcrumb
     *
     * @param object $resource
     * @return string
     */
    private static function createBreadcrumbs($resource)
    {
        //User configuration
        $breadcrumbs = $resource->get('values')->get('breadcrumbs');

        return collect($breadcrumbs)->map(function($url, $title) {
            //Current value -> empty url
            if(empty($title)) {
                return [
                    'title' => $url,
                    'url'   => null,
                ];
            }
            return [
                'title' => $title,
                'url'   => $url ? Html::urlBuilder($url) : null,
            ];
        })
        ->values()
        ->toArray();
    }
}
