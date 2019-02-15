<?php

namespace Daguilarm\Belich\Components\Navigation\Traits;

use Daguilarm\Belich\Facades\Belich;
use Illuminate\Support\Collection;
use Spatie\Menu\Html;
use Spatie\Menu\Link;
use Spatie\Menu\Menu;

trait NavbarHtml {

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
        $css = $this->merge(
            $this->brandCss,
            $this->lateralWidth,
            $this->brandBackground
        );

        return Link::to(Belich::url(), $brandName)
            ->addParentClass($css)
            ->addClass($this->brandLinkCss);
    }

    /**
     * Generate logout link
     *
     * @return string
     */
    public function getLogout()
    {
        $loadView = view('belich::partials.logout');
        $css = $this->merge(
            $this->logoutBackground,
            'float-right',
        );

        return Html::raw($loadView)
            ->addParentClass($css);
    }

    /*
    |--------------------------------------------------------------------------
    | Methods to generate links
    |--------------------------------------------------------------------------
    */

    /**
     * Generate a grouped link
     *
     * @param array $parameters
     * @return Spatie\Menu\Link
     */
    public function getGroupedLink(array $parameters) : Link
    {
        return Link::to('#', $parameters[1])
            ->addClass($this->menuCss())
            ->addClass($this->linkColor);
    }

    /**
     * Generate a no grouped link
     *
     * @param array $parameters
     * @return Spatie\Menu\Link
     */
    public function getNoGroupedLink(array $parameters) : Link
    {
        return Link::to($parameters[2], $parameters[0])
            ->addClass($this->menuCss())
            ->addClass($this->linkColor);
    }

    /**
     * Create submenu
     *
     * @param Illuminate\Support\Collection $resources
     * @return Spatie\Menu\Link
     */
    public function getSubmenuLinks(Collection $resources) : Menu
    {
        $submenu = Menu::new();
        $resources->map(function($resources) use ($submenu) {
            list($submenuLinkTitle, $submenuLinkTitleWithIcon, $submenuLinkUrl) = $this->getLinkParameters($resources);
            $link = Link::to($submenuLinkUrl, $submenuLinkTitle)->addClass($this->menuCss())->addClass($this->linkColor);
            $submenu->add($link);
        });

        return $submenu;
    }
}
