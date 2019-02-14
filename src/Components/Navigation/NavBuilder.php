<?php

namespace Daguilarm\Belich\Components\Navigation;

use Daguilarm\Belich\Core\Traits\System as Helpers;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\Menu\Html;
use Spatie\Menu\Link;
use Spatie\Menu\Menu;

abstract class NavBuilder {
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
        $url = route('logout');
        $text = trans('belich::buttons.base.logout');
        $link = sprintf('<a href="%s" onclick="event.preventDefault();document.getElementById(\'dashboard-logout\').submit();">%s</a>', $url, $text);
        $form = sprintf('<form id="dashboard-logout" action="%s" method="POST" style="display: none;">%s</form>', $url, csrf_field());

        return Html::raw($form . $link)->addParentClass('float-right logout');
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
    public static function withResources(Collection $resources)
    {
        //New menu with the brand
        $menu = Menu::new()
            ->add(static::brand());

        //Get the menu from the groups
        foreach(static::getGroups($resources) as $group) {
            //Generate new submenu for each group
            $submenu = Menu::new();

            //Grouped resources
            if($group) {
                //Get the submenus from the resources
                $submenu = static::getLink($submenu, $resources, $group);
                //Add the submenu
                $menu->submenu(Link::to('#', $group), $submenu);
            //Individual resources
            } else {
                $menu = static::getLink($menu, $resources, $group = null);
            }
        }

        return $menu->add(Self::logout());
    }

    /**
     * Get all the resources from the project
     *
     * @param Illuminate\Support\Collection $resources
     * @return string
     */
    public static function withoutResources()
    {
        //New menu with the brand
        return Menu::new()
            ->add(static::brand())
            ->add(Self::logout());
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

   /**
    * Get the navigation base link (grouped or individual)
    *
    * @param Spatie\Menu\Menu $resources
    * @param Illuminate\Support\Collection $resources
    * @param string $group
    * @return string
    */
   public static function getLink(Menu $menu, Collection $resources, $group = null)
   {
        foreach(static::getItems($resources)->where('group', $group) as $value) {
            if(!empty($value['pluralLabel'])) {
                $menu->link(Helpers::url() . '/' . $value['resource'], $value['pluralLabel']);
            }
        }

        return $menu;
   }
}
