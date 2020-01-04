<?php

namespace Daguilarm\Belich\Fields\Resolves\Handler;

use Closure;

final class NotVisualActions
{
    /**
     * @var string
     */
    private $action;

    /**
     * @var object
     */
    private $notResolveActions;

    /**
     * Init constructor
     *
     * @param object $sql
     * @param string $action
     *
     * @return Illuminate\Support\Collection
     */
    public function __construct(array $notResolveActions, string $action)
    {
        $this->notResolveActions = $notResolveActions;
        $this->action = $action;
    }

    /**
     * Prepare the fields for resolving...
     *
     * @param object $fields
     * @param object $sql
     *
     * @return Illuminate\Support\Collection
     */
    public function handle(object $fields, Closure $next): object
    {
        if (in_array($this->action, $this->noResolveActions)) {
            return $next(new Collection());
        }

        return $next($fields);
    }
}

