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
     * @return Spatie\Menu\Link
     */
    public function getBrand() : Link
    {
        $brandName = $this->brandName ?? Belich::name();

        return Link::to(Belich::url(), $brandName)
            ->addParentClass($this->brandCss())
            ->addClass($this->brandLinkCss());
    }

    /**
     * Generate logout link
     *
     * @return Spatie\Menu\Html
     */
    public function getLogout() : Html
    {
        $loadView = view('belich::partials.navigation.logout');

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
            ->addClass($this->linkCss());
    }

    /**
     * Generate a no grouped link
     *
     * @param array $parameters
     * @return void
     */
    public function getMenu(array $parameters) : void
    {
        $link = Link::to($parameters[2], $parameters[0])
            ->addClass($this->menuCss())
            ->addClass($this->linkCss())
            //Mark as parent (no grouped link)
            ->addParentClass('sidebar-parent');

        //Add the link in the menu
        $this->menu->add($link);
    }

    /**
     * Create submenu
     *
     * @param Illuminate\Support\Collection $resources
     * @return void
     */
    public function getDropdownMenu(array $parameters, Collection $resources) : void
    {
        //Create dropdown link
        $dropdown = $this->getGroupedLink($parameters);
        //Add links to dropdown
        $dropdownLinks = $this->getDropdownLinks($resources);
        //Generate the dropdown
        $this->menu
            ->submenu($dropdown, $dropdownLinks);
    }

    /**
     * Create dropdown links
     *
     * @param Illuminate\Support\Collection $resources
     * @return Spatie\Menu\Menu
     */
    public function getDropdownLinks(Collection $resources) : Menu
    {
        //Create the new menu
        $submenu = Menu::new()
            ->addParentClass($this->menuCss());
        //Adding links to the menu
        $resources->map(function($resources) use ($submenu) {
            //Links parameters
            list($title, $icon, $url) = $this->getLinkParameters($resources);
            //Populating the menu...
            $submenu->add(
                Link::to($url, $title)
                    ->addClass($this->menuCss())
                    ->addClass($this->linkCss())
                    //Mark as child
                    ->addParentClass('sidebar-child text-left')
            );
        });

        return $submenu;
    }
}
