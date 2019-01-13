<?php

namespace Daguilarm\Belich\Contracts;

interface Handler {

    /**
     * Handle an action
     *
     * @return object
     */
    public function handle();

    /**
     * Configure an action
     *
     * @return object
     */
    public function settings();
}
