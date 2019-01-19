<?php

namespace Daguilarm\Belich\Components;

use Illuminate\Support\Str;

trait Navbar {

    /*
    |--------------------------------------------------------------------------
    | Navbar
    |--------------------------------------------------------------------------
    */

    public static function navbar()
    {
        $resources = self::resourcesAll();

        dd($resources);

        $items =  collect($breadcrumbs)
            ->map(function($item) {
                if($item['url']) {
                    return sprintf('<li nav-breadcrumbs-items><a href="%s" class="text-blue font-bold">%s</a></li>', $item['url'], $item['title']);
                }
                return sprintf('<li nav-breadcrumbs-items-current>%s</li>', $item['title']);
            })
            ->implode('<li class="separator"></li>');

        return sprintf('<nav class="nav-breadcrumbs"><ul class="nav-breadcrumbs-list">%s</ul></nav>', $items);
    }
}
