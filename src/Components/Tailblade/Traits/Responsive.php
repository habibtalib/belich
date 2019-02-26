<?php

namespace Daguilarm\Belich\Components\Tailblade\Traits;

trait Responsive {

    /*
    |--------------------------------------------------------------------------
    | Responsive design
    |--------------------------------------------------------------------------
    */

    /**
     * Responsive design
     *
     * @param array $arg
     * @return self
     */
    public function responsive(string $size, ...$arg) : self
    {
        $this->addResponsiveAndStates($size, $arg);

        return $this;
    }
}
