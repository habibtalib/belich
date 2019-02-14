<?php

namespace Daguilarm\Belich\Components\Navigation;

use Illuminate\Support\Collection;

abstract class NavbarConstructor {

    /** @var string */
    protected $linkColor = 'text-white';

    /** @var string */
    protected $brandName;

    /** @var string */
    protected $brandBackground = 'bg-blue';

    /** @var string */
    protected $brandCss = 'font-semibold text-center';

    /** @var string */
    protected $brandLinkCss = 'text-white';

    /** @var string */
    protected $lateralWidth = 'w-48';

    /** @var array */
    public $menu;

    /** @var string */
    protected $menuBackground = 'bg-teal';

    /** @var string */
    protected $menuBackgroundHover = 'hover:bg-teal-dark';

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
