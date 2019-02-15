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
            $group->get('name'),
            $group->get('group') . $this->getDropdownIcon(),
            $group->get('hasGroup') === true ? '#' : $this->resourceUrl($group->get('resource')),
        ];
    }
}
