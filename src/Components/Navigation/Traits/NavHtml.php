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

        return Link::to(Belich::url(), $brandName)
            ->addParentClass('brand');
    }

    /**
     * Generate logout link
     *
     * @return string
     */
    public static function getLogout()
    {
        $text = trans('belich::buttons.base.logout');
        $link = sprintf('<a href="%s" onclick="event.preventDefault();document.getElementById(\'dashboard-logout\').submit();">%s</a>', route('logout'), $text);
        $form = sprintf('<form id="dashboard-logout" action="%s" method="POST" style="display: none;">%s</form>', route('logout'), csrf_field());

        return Html::raw($form . $link)->addParentClass('float-right logout');
    }

    /*
    |--------------------------------------------------------------------------
    | Methods to generate links
    |--------------------------------------------------------------------------
    */
    /**
     * Get the navigation base link (grouped or individual)
     *
     * @param string $group
     * @param Spatie\Menu\Menu $menu
     * @return string
     */
    public function createLink($group = null, $menu = null)
    {
        $result = $this->getSubgroups($this->resources)
            ->where('group', $group)
            ->map(function($value)  use ($menu) {
                //Set the resource title
                $title = $value['pluralLabel'] ?? $value['class'];
                //Link for Submenu
                if(!empty($menu)) {
                    return $menu->link(Belich::url() . '/' . $value['resource'], $title);
                //Link for Menu
                } else {
                    $this->menu->link(Belich::url() . '/' . $value['resource'], $title);
                }
            });

        //Return the submenu link
        if(!empty($menu)) {
            return $result->first() ?? \Spatie\Menu\Menu::new();
        }
    }
}
