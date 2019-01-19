<?php

namespace Daguilarm\Belich;

trait BelichOperations {

    public static function breadcrumbs($resource)
    {
        //Default value
        $breadcrumbs = $resource::$breadcrumbs;

        if(empty($breadcrumbs)) {
            $breadcrumbs = [
                trans('belich::belich.navigation.home') => self::url(),
                $resource::$pluralLabel,
            ];
        }

        return collect($breadcrumbs)
            ->map(function($url, $title) {
                //current item
                if(empty($title)) {
                    return [
                        'title' => $url,
                        'url'   => null,
                    ];
                }

                //List items
                return [
                    'title' => $title,
                    'url'   => $url,
                ];
            })
            ->values()
            ->toArray();
    }
}
