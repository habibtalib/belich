<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Resolves\Handler;

use Closure;

final class NotVisualActions
{
    private string $action;
    private array $notResolveActions;

    /**
     * Init constructor
     */
    public function __construct(array $notResolveActions, string $action)
    {
        $this->notResolveActions = $notResolveActions;
        $this->action = $action;
    }

    /**
     * Prepare the fields for resolving...
     */
    public function handle(object $fields, Closure $next): object
    {
        if (in_array($this->action, $this->noResolveActions)) {
            return $next(new Collection());
        }

        return $next($fields);
    }
}
