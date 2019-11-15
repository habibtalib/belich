<?php

namespace Daguilarm\Belich\Contracts;

interface FieldNumberContract
{
    /**
     * Set min value
     *
     * @param string $min
     */
    public function min(string $min);

    /**
     * Set max value
     *
     * @param string $max
     */
    public function max(string $max);

    /**
     * Set step value
     *
     * @param string $step
     */
    public function step(string $step);
}
