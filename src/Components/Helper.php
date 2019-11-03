<?php

namespace Daguilarm\Belich\Components;

class Helper
{
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
    }
}
