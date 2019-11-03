<?php

/*
|--------------------------------------------------------------------------
| Routes
|--------------------------------------------------------------------------
*/

/**
 * Generate the form route for the action attribute
 *
 * @param string $redirectTo ['index', 'edit', 'update', 'show']
 *
 * @return string
 */
if (!function_exists('toRoute')) {
    function toRoute(string $redirectTo): string
    {
        $route = sprintf('%s.%s.%s', Belich::pathName(), Belich::resource(), $redirectTo);
        $id = Belich::resourceId() ?? 0;

        return ($id > 0)
            ? route($route, $id)
            : route($route);
    }
}
