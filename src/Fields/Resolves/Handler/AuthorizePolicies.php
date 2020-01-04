<?php

namespace Daguilarm\Belich\Fields\Resolves\Handler;

use Closure;

final class AuthorizePolicies {

    /**
     * @var string
     */
    private $action;

    /**
     * @var object
     */
    private $sql;

    /**
     * Init constructor
     *
     * @param object $sql
     * @param string $action
     *
     * @return Illuminate\Support\Collection
     */
    public function __construct(object $sql, string $action)
    {
        $this->sql = $sql;
        $this->action = $action;
    }

    /**
     * Handle policies
     *
     * @param object $fields
     * @param Closure $next
     *
     * @return Illuminate\Support\Collection
     */
    public function handle($fields, Closure $next)
    {
        //Authorized access to show action
        if ($this->action === 'show' && ! request()->user()->can('view', $this->sql)) {
            return abort(403);
        }

        //Authorized access to edit or update action
        if (($this->action === 'edit' || $this->action === 'update') && ! request()->user()->can('update', $this->sql)) {
            return abort(403);
        }

        //Prepare the fields for resolving...
        return $next($fields);
    }
}

