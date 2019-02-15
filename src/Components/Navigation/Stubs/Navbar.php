<?php

namespace App\Belich;

use Daguilarm\Belich\Components\Navigation\Navbar as BaseNavbar;
use Illuminate\Support\Collection;
use Spatie\Menu\Html;
use Spatie\Menu\Link;
use Spatie\Menu\Menu;

class Navbar extends BaseNavbar {

    /**
     * Generate the navbar
     *
     * @param Illuminate\Support\Collection $resources
     * @return void
     */
    public function get()
    {
        //Generate the navbar without resources
        if(config('belich.navbar') === 'sidebar') {
            return Parent::withoutResources()->menu->render();
        }

        return Parent::withResources()->menu->render();
    }
}
