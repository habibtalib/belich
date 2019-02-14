<?php

namespace Daguilarm\Belich\Components\Navigation;

use Illuminate\Support\Collection;

abstract class NavbarConstructor {

    /** @var string */
    protected $brandName;

    /** @var string */
    protected $brandBackground = 'bg-blue';

    /** @var string */
    protected $brandWidth = '14rem';

    /** @var array */
    public $menu;

    /** @var string */
    protected $menuBackground = 'bg-teal';

    /** @var Illuminate\Support\Collection */
    protected $resources;

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
