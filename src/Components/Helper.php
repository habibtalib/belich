<?php

namespace Daguilarm\Belich\Components;

use Daguilarm\Belich\Components\Helpers\Blade;
use Daguilarm\Belich\Components\Helpers\Forms;
use Daguilarm\Belich\Components\Helpers\Metrics;
use Daguilarm\Belich\Components\Helpers\Models;

class Helper
{
    use Blade, Forms, Metrics, Models;

    /**
     * Generate helper's methods
     *
     * @param  string $method
     * @param  array $parameters
     *
     * @return Boolean
     */
    public function __call($method, $parameters)
    {
        if (method_exists($this, $method)) {
            return call_user_func_array([$this, $method], $parameters);
        }
        throw new \InvalidArgumentException('The method ' . $method . '() not exists');
    }
}
