<?php

namespace Daguilarm\Belich\Core;

use Daguilarm\Belich\Core\Search;
use Daguilarm\Belich\Facades\Belich;
use Daguilarm\Belich\Facades\Helper;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cookie;

final class Database4
{
    /**
     * Create the Sql Connection
     *
     * @param string $class
     * @param string $request
     *
     * @return object
     */
    public function response(object $class, $request): object
    {
        // ddd(Belich::getModel(), Helper::hasSoftdelete(Belich::getModel()));
        //Init search helper
        $search = app(Search::class);

        //Set variables
        $direction = $request->query('direction');
        $order = $request->query('orderBy');
        $policy = $request->user()->can('withTrashed', Belich::getModel());

        //Sql for index
        if (Belich::action() === 'index') {
            return $class
                //Add the current resource query
                ->indexQuery($request)

                //Live search
                ->when($search->requestFromSearch(), static function ($query) use ($request, $search) {
                    //No results
                    if ($request->query('query') === 'resetSearchAll') {
                        return $query;
                    }
                    //Get the results
                    collect($search->requestTableFields())->each(static function ($field) use ($query, $request): void {
                        $query->orWhere($field, 'LIKE', '%' . $request->query('query') . '%');
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
                ->appends($request->query());
        }

        return Belich::action() === 'edit' || Belich::action() === 'show' && is_numeric(Belich::resourceId())
            //Sql for edit and show
            ? $class->model()->findOrFail(Belich::resourceId())
            // Default value
            : new Collection();
    }
}
