<?php

namespace Daguilarm\Belich\Components;

use Daguilarm\Belich\Core\Helpers;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\Menu\Html;
use Spatie\Menu\Link;
use Spatie\Menu\Menu;

abstract class Navigation {
    /*
    |--------------------------------------------------------------------------
    | Navigation methods
    |--------------------------------------------------------------------------
    */

    /**
     * Generate the navbar brand
     *
     * @return string
     */
    public static function brand()
    {
        return Link::to(Helpers::url(), Helpers::name())
            ->addParentClass('brand');
    }

    /**
     * Generate link for resource
     *
     * @param string $resource
     * @param Illuminate\Support\Collection $resources
     * @return string
     */
    public static function resource(string $resource, Collection $resources)
    {
        //Default values
        $resource = Str::plural(Str::lower($resource));
        $label    = $resources[$resource]['pluralLabel'] ?? null;
        $url      = sprintf('%s/%s', Helpers::url(), $resource);

        return $label
            ? Link::to($url, $label)
            : abort(403, trans('belich::exceptions.no_resource'));
    }

    /**
     * Generate logout link
     *
     * @return string
     */
    public static function logout()
    {
        $url = Helpers::url() . '/logout';
        $text = trans('belich::buttons.base.logout');

        return Link::to($url, $text)->addParentClass('float-right logout');
    }

    /*
    |--------------------------------------------------------------------------
    | Generate navbar from resources
    |--------------------------------------------------------------------------
    */

    /**
     * Get all the resources from the project
     *
     * @param Illuminate\Support\Collection $resources
     * @return string
     */
    public static function resourcesForNavigation(Collection $resources)
    {
        //New menu with the brand
        $menu = Menu::new()
            ->add(Self::brand());

        //Get the menu from the groups
        foreach(Self::getGroups($resources) as $group) {
            //Generate new submenu for each group
            $submenu = Menu::new();
            //Get the submenus from the resources
            foreach(Self::getItems($resources)->where('group', $group) as $value) {
                if(!empty($value['pluralLabel'])) {
                    $submenu->link(Helpers::url() . '/' . $value['resource'], $value['pluralLabel']);
                }
            }
            //Add the submenu
            $menu->submenu(Link::to('#', $group), $submenu);
        }

        return $menu->add(Self::logout());
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

   /**
    * Get all the resources from the project
    *
    * @param Illuminate\Support\Collection $resources
    * @return string
    */
   public static function getGroups(Collection $resources)
   {
        return collect($resources)
            ->map(function ($item, $key) {
                return $item['group'];
            })
            ->unique()
            ->values();
   }

   /**
    * Get all the resources from the project
    *
    * @param Illuminate\Support\Collection $resources
    * @return string
    */
   public static function getItems(Collection $resources)
   {
        return collect($resources)
            ->map(function ($items) {
                return $items->toArray();
            })
            ->values();
   }
}
