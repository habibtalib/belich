<?php

namespace Daguilarm\Belich\Components\Navigation\Traits;

use Illuminate\Support\Collection;

trait Helpers {

    /*
    |--------------------------------------------------------------------------
    | Links helpers
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
            icon($group->get('icon'), $group->get('name'), 'icon-light'),
            $group->get('group') . $this->getDropdownIcon(),
            $this->resourceUrl($group->get('resource')),
        ];
    }
}
