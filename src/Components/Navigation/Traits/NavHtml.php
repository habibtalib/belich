<?php

namespace Daguilarm\Belich\Components\Navigation\Traits;

use Daguilarm\Belich\Facades\Belich;
use Spatie\Menu\Html;
use Spatie\Menu\Link;

trait NavHtml {

    /*
    |--------------------------------------------------------------------------
    | Methods to generate <li> blocks
    |--------------------------------------------------------------------------
    */

    /**
     * Generate the navbar brand
     *
     * @return string
     */
    public function getBrand()
    {
        $brandName = $this->brandName ?? Belich::name();
        $css = $this->merge($this->brandCss, $this->lateralWidth, $this->brandBackground);

        return Link::to(Belich::url(), $brandName)
            ->addParentClass($css)
            ->addClass($this->brandLinkCss);
    }

    /**
     * Generate logout link
     *
     * @return string
     */
    public static function getLogout()
    {
        $loadView = view('belich::partials.settings');

        return Html::raw($loadView)->addParentClass('float-right');
    }

    /*
    |--------------------------------------------------------------------------
    | Methods to generate links
    |--------------------------------------------------------------------------
    */
    public function createSubMenus($group, $submenu)
    {
        return $this->getSubgroups($this->resources)
            ->where('group', $group)
            ->map(function($value) use ($submenu) {
                //Set default variables for the menu
                $linkTitle = $value['pluralLabel'] ?? stringPluralUpper($value['class']);
                $linkUrl = $this->resourceUrl($value['resource']);

                return $submenu->add(Link::to($linkUrl, $linkTitle)->addClass($this->linkColor));
            })
            ->first();
    }
    // /**
    //  * Get the navigation base link (grouped or individual)
    //  *
    //  * @param string $group
    //  * @param Spatie\Menu\Menu $menu
    //  * @return string
    //  */
    // public function createLink($group, $menu = null)
    // {
    //     $result = $this->getSubgroups($this->resources)
    //         ->map(function($value)  use ($menu) {
    //             //Set the resource title
    //             $title = $value['pluralLabel'] ?? $value['class'];
    //             //Set the resource URL
    //             $resourceUrl = Belich::url() . '/' . $value['resource'];
    //             //Submenu class
    //             $submenuClass = $this->merge($this->submenuBackground, $this->submenuBackgroundHover);

    //             if($value['group']) {
    //                 //Link for Submenu
    //                 if(!empty($menu)) {
    //                     return $menu->add(Link::to($resourceUrl, $title)->addClass($this->linkColor))->addClass($submenuClass);
    //                 //Link for Menu
    //                 } else {
    //                     $this->menu->add(Link::to($resourceUrl, $title)->addClass($this->linkColor))->addClass($submenuClass);
    //                 }
    //             //No group result
    //             } else {
    //                 $this->menu->add(Link::to($resourceUrl, $title)->addClass($this->linkColor));
    //             }
    //         });

    //     //Return the submenu link
    //     if(!empty($menu)) {
    //         return $result->first() ?? \Spatie\Menu\Menu::new();
    //     }
    // }
}
