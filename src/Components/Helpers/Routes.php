<?php

namespace Daguilarm\Belich\Components\Helpers;

use Daguilarm\Belich\Facades\Belich;

trait Routes
{
    /**
     * Generate the form route for the action attribute
     *
     * @param string $redirectTo ['index', 'edit', 'update', 'show']
     *
     * @return string
     */
    private function toRoute(string $redirectTo): string
    {
        $route = sprintf('%s.%s.%s', Belich::pathName(), Belich::resource(), $redirectTo);
        $id = Belich::resourceId() ?? 0;

        return $id > 0
            ? route($route, $id)
            : route($route);
    }
}
