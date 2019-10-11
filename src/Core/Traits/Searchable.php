<?php

namespace Daguilarm\Belich\Core\Traits;

use Illuminate\Support\Facades\Request;

trait Searchable {

    /*
    |--------------------------------------------------------------------------
    | Public Static Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Set if the request is from a live search
     *
     * @return string
     */
    public static function requestFromSearch() : bool
    {
        $request = request()->query();

        if(!empty($request['query']) && !empty($request['resourceName']) && strlen($request['query']) >= config('belich.minSearch')) {
            return true;
        }

        return false;
    }
}
