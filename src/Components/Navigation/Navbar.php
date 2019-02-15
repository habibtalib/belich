<?php

namespace Daguilarm\Belich\Components\Navigation;

use Daguilarm\Belich\Components\Navigation\NavbarConstructor;
use Daguilarm\Belich\Components\Navigation\Traits\NavHtml;
use Daguilarm\Belich\Components\Navigation\Traits\Operations;
use Daguilarm\Belich\Components\Navigation\Traits\Settings;
use Daguilarm\Belich\Core\Traits\System as Helpers;
use Daguilarm\Belich\Facades\Belich;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\Menu\Html;
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

        collect($this->getGroups())->map(function($group) {
            //Set default variables for the menu
            $linkTitle = $group->get('name');
            $linkUrl = $group->get('hasGroup') === true ? '#' : $this->resourceUrl($group->get('resource'));

            if($group->get('hasGroup') === true) {
                $submenu = $this->createSubMenus($group->get('name'), Menu::new());
                $this->menu->submenu(Link::to($linkUrl, $linkTitle)->addClass($this->linkColor), $submenu);
            } else {
                $this->menu->add(Link::to($linkUrl, $linkTitle)->addClass($this->linkColor));
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
