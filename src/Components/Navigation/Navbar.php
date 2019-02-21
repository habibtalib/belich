<?php

namespace Daguilarm\Belich\Components\Navigation;

use Daguilarm\Belich\Components\Navigation\NavbarConstructor;
use Daguilarm\Belich\Components\Navigation\Traits\Helperable;
use Daguilarm\Belich\Components\Navigation\Traits\Operationable;
use Daguilarm\Belich\Components\Navigation\Traits\Renderable;
use Daguilarm\Belich\Components\Navigation\Traits\Settingable;
use Illuminate\Support\Collection;
use Spatie\Menu\Menu;

class Navbar extends NavbarConstructor {

    use Helperable, Operationable, Renderable, Settingable;

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
     * @return self
     */
    public function navbarWithResources() : self
    {
        //New menu with the brand
        $this->menu = Menu::new()->add($this->getBrand());

        //List of resources to be listed as menu
        $this->getResources()
            ->map(function($resources, $group) {
                //Get the link parameters for the menu
                $parameters = $this->getLinkParameters($resources->first());

                //Set the menu
                return ($resources->count() <= 1)
                    //Simple menu link
                    ? $this->getMenu($parameters)
                    //Grouped menu links with dropdown
                    : $this->getDropdownMenu($parameters, $resources);
            });

        //Add the logout
        $this->menu->add($this->getLogout());

        return $this;
    }

    /**
     * Get all the resources from the project
     *
     * @return self
     */
    public function navbarWithoutResources() : self
    {
        //Configure css
        $this->settings(function() {
            return [
                'brandBackground' => 'bg-grey-darkest',
            ];
        });

        //New menu with the brand
        $this->menu = Menu::new()
            ->add($this->getBrand())
            ->add($this->getLogout());

        return $this;
    }

    /**
     * Get all the resources from the project
     *
     * @return self
     */
    public function sidebarWithResources() : self
    {
        //New menu with the brand
        $this->menu = Menu::new();

        //List of resources to be listed as menu
        $this->getResources()
            ->map(function($resources, $group) {
                //Get the link parameters for the menu
                $parameters = $this->getLinkParameters($resources->first());

                //Set the menu
                return ($resources->count() <= 1)
                    //Simple menu link
                    ? $this->getMenu($parameters)
                    //Grouped menu links with dropdown
                    : $this->getDropdownMenu($parameters, $resources);
            });

        return $this;
    }
}
