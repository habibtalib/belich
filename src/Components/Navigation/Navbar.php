<?php

namespace Daguilarm\Belich\Components\Navigation;

use Daguilarm\Belich\Components\Navigation\NavbarConstructor;
use Daguilarm\Belich\Components\Navigation\Traits\NavHtml;
use Daguilarm\Belich\Components\Navigation\Traits\Operations;
use Daguilarm\Belich\Components\Navigation\Traits\Settings;
use Illuminate\Support\Collection;
use Spatie\Menu\Link;
use Spatie\Menu\Menu;

class Navbar extends NavbarConstructor {

    use NavHtml, Operations, Settings;

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

        //Create the groups and subgroups
        collect($this->getGroups())
            ->map(function($group) {
                //Set default variables for the menu
                list($linkTitle, $linkTitleWithIcon, $linkUrl) = $this->getLinkParameters($group);

                //Create a grouped menu
                if($group->get('hasGroup') === true) {
                    //First create the submenu
                    $submenu = $this->createSubMenus($group->get('name'), Menu::new());
                    //Now create the parent menu link
                    $menuLink = Link::to($linkUrl, $linkTitleWithIcon)->addClass($this->menuCss())
                        ->addClass($this->linkColor);
                    //And now add the submenu to the parent menu
                    $this->menu->submenu($menuLink, $submenu)
                        ->addParentClass($this->menuBackgroundActive);

                //Individual link (no grouped link)
                } else {
                    //Generate the "no grouped link"
                    $noGroupedLink = Link::to($linkUrl, $linkTitle)
                        ->addClass($this->linkColor)
                        ->addParentClass($this->menuCss());
                    //Add to the menu
                    $this->menu->add($noGroupedLink);
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

    /*
    |--------------------------------------------------------------------------
    | Navigation helpers
    |--------------------------------------------------------------------------
    */

    /**
     * Get the parameters for a menu link
     *
     * @param Collection $group
     * @return string
     */
    public function getLinkParameters(Collection $group) : array
    {
        return [
            $group->get('name'),
            $group->get('name') . $this->getDropdownIcon(),
            $group->get('hasGroup') === true ? '#' : $this->resourceUrl($group->get('resource')),
        ];
    }
}
