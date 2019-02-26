<?php

namespace Daguilarm\Belich\Components\Tailblade\Traits;

trait States {

    /*
    |--------------------------------------------------------------------------
    | State Variants
    |--------------------------------------------------------------------------
    */

    /**
     * Generate the hover state
     *
     * @param array $arg
     * @return self
     */
    public function hover(...$arg) : self
    {
        $this->addResponsiveAndStates('hover', $arg);

        return $this;
    }

    /**
     * Generate the focus state
     *
     * @param array $arg
     * @return self
     */
    public function focus(...$arg) : self
    {
        $this->addResponsiveAndStates('focus', $arg);

        return $this;
    }

    /**
     * Generate the active state
     *
     * @param array $arg
     * @return self
     */
    public function active(...$arg) : self
    {
        $this->addResponsiveAndStates('active', $arg);

        return $this;
    }
}
