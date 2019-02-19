<?php

namespace Daguilarm\Belich\Core\Traits;

use Daguilarm\Belich\Facades\Belich;
use Illuminate\Support\Facades\Cookie;

trait SqlConnection {

    /**
    * Create the Sql Connection
    *
    * @param string $class
    * @return object
    */
    private function sqlConnectionResponse(object $class) : object
    {
        //Set variables
        $direction = request()->query('direction');
        $order     = request()->query('orderBy');
        $policy    = request()->user()->can('withTrashed', Belich::getModel());

        //Sql for index
        if(static::action() === 'index') {
            return $class
                //Add the current resource query
                ->indexQuery($this->request)

                //Order query
                ->when(!empty($order) && !empty($direction), function ($query) use ($direction, $order) {
                    return $query->orderBy($order, $direction);
                })

                //Show the trashed results
                ->when($policy && Cookie::get('belich_withTrashed') === 'all', function ($query) {
                    return $query->withTrashed();
                })

                //Only show the trashed results
                ->when($policy && Cookie::get('belich_withTrashed') === 'only', function ($query) {
                    return $query->onlyTrashed();
                })

                //Pagination
                ->simplePaginate(Cookie::get('belich_perPage'))

                //Add all the url variables
                ->appends(request()->query());
        }

        //Sql for edit and show
        if(static::action() === 'edit' || static::action() === 'show' && is_numeric(static::resourceId())) {
            return $class
                ->model()
                ->findOrFail(static::resourceId());
        }

        return new \Illuminate\Database\Eloquent\Collection;
    }
}
