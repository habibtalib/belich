<?php

namespace Daguilarm\Belich\Core\Traits;

use Daguilarm\Belich\Facades\Belich;

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
        $trashed   = request()->query('withTrashed');
        $policy    = request()->user()->can('withTrashed', Belich::getModel());

        //Sql for index
        if(static::action() === 'index') {
            return $class
                //Add the current resource query
                ->indexQuery($this->request)

                //Order query
                ->when(!empty($order) && !empty($direction), function ($query) use ($direction, $order, $policy, $trashed) {
                    return $query->orderBy($order, $direction);
                })

                //Trashed
                ->when(!empty($trashed) && $trashed === 'true' && $policy, function ($query) {
                    return $query->withTrashed();
                })

                //Pagination
                ->simplePaginate($this->perPage)

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
