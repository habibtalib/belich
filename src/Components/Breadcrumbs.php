<?php

namespace Daguilarm\Belich\Components;

use Illuminate\Support\Collection;

trait Breadcrumbs {

    /**
     * Generate the resource breadcrumbs
     *
     * @return array
     */
    private function breadcrumbsCreate($settings, $items = []) : array
    {
        //Get the value
        $breadcrumbs = $this->resourceClass::$breadcrumbs;

        //Resource custom values
        if(!empty($breadcrumbs)) {
            return $this->breadcrumbsCustom($breadcrumbs);
        }

        //Default breadcrumbs
        return $this->breadcrumbsDefault($settings);
    }

    private function breadcrumbsCustom($breadcrumbs, $items = []) {
        foreach($breadcrumbs as $title => $url) {
            if(empty($title)) {
                $items[$url] = null;
            } elseif($title && $url) {
                $items[$title] = $url;
            }
        }
        return $items;
    }

    private function breadcrumbsDefault($settings, $items = []) : array
    {
        //Home
        $items[trans('belich::belich.navigation.home')] = belich_path();

        //Add group list
        if($settings->group !== $settings->labels) {
            $items[$settings->group] = null;
        }

        //Add current path
        $items[$settings->labels] = null;

        return $items;
    }
}
