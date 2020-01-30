<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Components\Helpers;

use Daguilarm\Belich\Facades\Belich;

trait Routes
{
    /**
     * Generate the form route for the action attribute
     *
     * @param string $redirectTo ['index', 'edit', 'update', 'show']
     */
    public function toRoute(string $redirectTo): string
    {
        // Add custom form action from Resource
        if (Belich::controllerAction()) {
            return action(Belich::controllerAction() . '@' . $redirectTo, Belich::resourceId() ?? null);
        }

        $route = sprintf('%s.%s.%s', Belich::pathName(), Belich::resource(), $redirectTo);
        $id = Belich::resourceId() ?? 0;

        return $id > 0
            ? route($route, $id)
            : route($route);
    }
}
