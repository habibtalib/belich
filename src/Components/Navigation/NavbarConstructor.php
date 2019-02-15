<?php

namespace Daguilarm\Belich\Components\Navigation;

use Illuminate\Support\Collection;

abstract class NavbarConstructor {

    /** @var string */
    protected $dropdownIcon;

    /** @var string */
    protected $linkColor = 'text-white';

    /** @var string */
    protected $linkColorHover = 'hover:text-yellow';

    /** @var string */
    protected $brandName;

    /** @var string */
    protected $brandBackground = 'bg-teal-dark';

    /** @var string */
    protected $brandText = 'font-semibold text-center';

    /** @var string */
    protected $brandLink = 'text-white';

    /** @var string */
    protected $brandLinkHover = 'hover:text-yellow';

    /** @var string */
    protected $brandWidth = 'w-48';

    /** @var string */
    protected $logoutBackground = 'bg-grey-lighter';

    /** @var array */
    public $menu;

    /** @var string */
    protected $menuBackground = 'bg-teal-light';

    /** @var string */
    protected $menuBackgroundHover = 'hover:bg-teal';

    /** @var Illuminate\Support\Collection */
    protected $resources;

    /** @var string */
    protected $submenuBackground = 'bg-teal';

    /** @var string */
    protected $submenuBackgroundHover = 'hover:bg-teal-dark';

    /**
     * Initialize the constructor
     *
     * @return string
     */
    public function __construct(Collection $resources)
    {
        $this->resources = $resources;
    }
}
