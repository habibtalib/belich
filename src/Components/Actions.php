<?php

namespace Daguilarm\Belich\Components;

use Utils;

class Actions {

    /*
    |--------------------------------------------------------------------------
    | Actions
    |--------------------------------------------------------------------------
    */

    /**
     * Generate the breadcrumb
     *
     * @return string
     */
    public static function make($resource)
    {
        $show = sprintf('<a href="#" class="text-grey text-lg p-2">%s</a>', Utils::icon('eye'));
        $edit = sprintf('<a href="#" class="text-grey text-lg p-2">%s</a>', Utils::icon('edit'));
        $delete = sprintf('<a href="#" class="text-grey text-lg p-2">%s</a>', Utils::icon('trash'));

        return $show . $edit . $delete;
    }
}
