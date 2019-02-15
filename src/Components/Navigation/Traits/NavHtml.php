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
                //Get the submenu
                return $submenu->add(Link::to($linkUrl, $linkTitle)->addClass($this->linkColor))->addClass($this->submenuCss());
            })
            ->first();
    }
}
