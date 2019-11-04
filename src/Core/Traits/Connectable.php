<?php

namespace Daguilarm\Belich\Core\Traits;

use Daguilarm\Belich\Core\Traits\Searchable;
use Daguilarm\Belich\Facades\Belich;
use Daguilarm\Belich\Facades\Helper;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cookie;

trait Connectable
{
    use Searchable;

    /**
     * Create the Sql Connection
     *
     * @param string $class
     *
     * @return object
     */
    private function sqlConnectionResponse(object $class): object
    {
        //Set variables
        $direction = request()->query('direction');
        $order = request()->query('orderBy');
        $policy = request()->user()->can('withTrashed', Belich::getModel());

        //Sql for index
        if (static::action() === 'index') {
            return $class
                //Add the current resource query
                ->indexQuery($this->request)

                //Live search
                ->when(self::requestFromSearch(), function ($query) {
                    //No results
                    if ($this->request->query('query') === 'resetSearchAll') {
                        return $query;
                    }
                    //Get the results
                    collect(self::requestTableFields())->each(function ($field) use ($query): void {
                        $query->orWhere($field, 'LIKE', '%' . $this->request->query('query') . '%');
                    });
                })

                //Order query
                ->when(isset($order) && isset($direction), static function ($query) use ($direction, $order) {
                    return $query->orderBy($order, $direction);
                })

                //Show the trashed results
                ->when($policy && Helper::hasSoftdelete(Belich::getModel()) && Cookie::get('belich_withTrashed') === 'all', static function ($query) {
                    return $query->withTrashed();
                })

                //Only show the trashed results
                ->when($policy && Helper::hasSoftdelete(Belich::getModel()) && Cookie::get('belich_withTrashed') === 'only', static function ($query) {
                    return $query->onlyTrashed();
                })

                //Pagination
                ->simplePaginate(Cookie::get('belich_perPage'))

                //Add all the url variables
                ->appends(request()->query());
        }

        return static::action() === 'edit' || static::action() === 'show' && is_numeric(static::resourceId())
            //Sql for edit and show
            ? $class->model()->findOrFail(static::resourceId())
            // Default value
            : new Collection();
    }
}
