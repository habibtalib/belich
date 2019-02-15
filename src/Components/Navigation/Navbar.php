<?php

namespace Daguilarm\Belich\Components\Navigation;

use Daguilarm\Belich\Components\Navigation\NavbarConstructor;
use Daguilarm\Belich\Components\Navigation\Traits\Helpers;
use Daguilarm\Belich\Components\Navigation\Traits\NavbarHtml;
use Daguilarm\Belich\Components\Navigation\Traits\Operations;
use Daguilarm\Belich\Components\Navigation\Traits\Settings;
use Illuminate\Support\Collection;
use Spatie\Menu\Link;
use Spatie\Menu\Menu;

class Navbar extends NavbarConstructor {

    use Helpers, NavbarHtml, Operations, Settings;

    protected $groupedLinks;

    /**
     * Initialize the constructor
     *
     * @return string
     */
    public function __construct(Collection $resources)
    {
        parent::__construct($resources);
    }

    /*
    |--------------------------------------------------------------------------
    | Navigation methods
    |--------------------------------------------------------------------------
    */

    /**
     * Get all the resources from the project
     *
     * @return string
     */
    public function withResources()
    {
        //New menu with the brand
        $this->menu = Menu::new()->add($this->getBrand());

        $resources = $this->getResources()
            ->map(function($resources, $group) {
                //Get the link parameters
                $parameters = $this->getLinkParameters($resources->first());

                //Simple menu link
                if($resources->count() <= 1) {
                    $simpleLink = $this->getNoGroupedLink($parameters);
                    //Create the simple link in the menu
                    $this->menu->add($simpleLink);
                } else {
                    $parentLink = $this->getGroupedLink($parameters);
                    $submenu = $this->getSubmenuLinks($resources);
                    //Create submenu
                    $this->menu->submenu($parentLink, $submenu)
                        ->addParentClass($this->menuBackgroundActive);
                }
            });

        //Add the logout
        $this->menu->add($this->getLogout());

        return $this;
    }

    /**
     * Get all the resources from the project
     *
     * @return string
     */
    public function withoutResources()
    {
        //New menu with the brand
        $this->menu = Menu::new()
            ->add($this->getBrand())
            ->add($this->getLogout());

        return $this;
    }
}
