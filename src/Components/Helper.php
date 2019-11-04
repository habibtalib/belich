<?php

namespace Daguilarm\Belich\Components;

use Daguilarm\Belich\Components\Helpers\Blade;
use Daguilarm\Belich\Components\Helpers\Files;
use Daguilarm\Belich\Components\Helpers\Forms;
use Daguilarm\Belich\Components\Helpers\Icons;
use Daguilarm\Belich\Components\Helpers\Messages;
use Daguilarm\Belich\Components\Helpers\Metrics;
use Daguilarm\Belich\Components\Helpers\Models;
use Daguilarm\Belich\Components\Helpers\Paths;
use Daguilarm\Belich\Components\Helpers\Strings;

class Helper
{
    use Blade, Icons, Files, Forms, Messages, Metrics, Models, Paths, Strings;

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
