<?php

namespace Daguilarm\Belich\Components\Tailblade\Traits;

trait Css {

    /*
    |--------------------------------------------------------------------------
    | Css methods
    |--------------------------------------------------------------------------
    */

    /**
     * Generate the background color
     *
     * @param array $arg
     * @return self
     */
    public function addClass(...$arg) : self
    {
        $addClass = collect($arg)
            ->each(function($class) {
                $this->classes[] = $class;
            });

        return $this;
    }
}
