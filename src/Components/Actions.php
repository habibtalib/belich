<?php

namespace Daguilarm\Belich\Components;

use Illuminate\Http\Request;
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
    public static function make()
    {
        $show   = sprintf('<a href="%s" class="action">%s</a>', Utils::route('show'), Utils::icon('eye'));
        $edit   = sprintf('<a href="%s" class="action">%s</a>', Utils::route('edit'), Utils::icon('edit'));
        $delete = sprintf('<a href="#" class="action" data-url="%s">%s</a>', Utils::route('destroy'), Utils::icon('trash'));

        return $show . $edit . $delete;
    }
}
