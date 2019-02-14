<?php

namespace Daguilarm\Belich\Components\Navigation;

use Daguilarm\Belich\Components\Navigation\NavbarConstructor;
use Daguilarm\Belich\Components\Navigation\Traits\NavHtml;
use Daguilarm\Belich\Components\Navigation\Traits\Operations;
use Daguilarm\Belich\Core\Traits\System as Helpers;
use Daguilarm\Belich\Facades\Belich;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\Menu\Html;
use Spatie\Menu\Link;
use Spatie\Menu\Menu;

class Navbar extends NavbarConstructor {

    use NavHtml, Operations;

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

        //Get the menu from the groups
        foreach($this->getGroups() as $group) {

            //Generate new submenu for each group
            $submenu = Menu::new();

            //Grouped resources
            if($group) {
                //Get the submenus from the resources
                $submenu = $this->createLink($group, $submenu);
                //Add the submenu
                $this->menu->submenu(Link::to('#', $group), $submenu);

            //Individual resources
            } else {
                $this->menu->add($this->createLink($group = null));
            }
        }

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

    public function setBrandName($text)
    {
        $this->brandName = $text;

        return $this;
    }
}
