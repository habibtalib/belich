<?php

namespace Daguilarm\Belich\Components\Navigation;

use Daguilarm\Belich\Core\Traits\System as Helpers;
use Daguilarm\Belich\Facades\Belich;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\Menu\Html;
use Spatie\Menu\Link;
use Spatie\Menu\Menu;

class NavbarConstructor {

    /** @var array */
    public $menu;
    /** @var string */
    private $menuBackground = 'bg-teal';

    /** @var string */
    private $brandName;
    private $brandBackground = 'bg-blue';
    private $brandWidth = '14rem';

    /** @var Illuminate\Support\Collection */
    private $resources;

    public function __construct(Collection $resources)
    {
        $this->resources = $resources;
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

    /*
    |--------------------------------------------------------------------------
    | Navigation constructors
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

        return Link::to(Helpers::url(), $brandName)
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
    | Navigation operations
    |--------------------------------------------------------------------------
    */
    /**
     * Get all the resources from the project
     *
     * @return string
     */
    public function getGroups()
    {
         return collect($this->resources)
             ->map(function ($item, $key) {
                 return $item['group'];
             })
             ->unique()
             ->values();
    }

    /**
     * Get all the resources from the project
     *
     * @return string
     */
    public function getSubgroups()
    {
         return collect($this->resources)
             ->map(function ($items) {
                 return $items->toArray();
             })
             ->values();
    }

    /**
     * Get the navigation base link (grouped or individual)
     *
     * @param string $group
     * @param Spatie\Menu\Menu $menu
     * @return string
     */
    public function createLink($group = null, $menu = null)
    {
        foreach($this->getSubgroups($this->resources)->where('group', $group) as $value) {
            if(!empty($value['pluralLabel'])) {
                if(!empty($menu)) {
                    $menu->link(Helpers::url() . '/' . $value['resource'], $value['pluralLabel']);
                } else {
                    $this->menu->link(Helpers::url() . '/' . $value['resource'], $value['pluralLabel']);
                }
            }
        }
        if(!empty($menu)) {
            return $menu;
        }
    }

    public function setBrandName($text)
    {
        $this->brandName = $text;

        return $this;
    }
}
