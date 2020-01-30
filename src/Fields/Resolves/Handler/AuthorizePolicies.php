<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Resolves\Handler;

use Closure;

final class AuthorizePolicies
{
    private string $action;
    private object $sql;

    public function __construct(object $sql, string $action)
    {
        $this->sql = $sql;
        $this->action = $action;
    }

    /**
     * Handle policies
     */
    public function handle($fields, Closure $next): object
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
