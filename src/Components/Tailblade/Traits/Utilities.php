<?php

namespace Daguilarm\Belich\Components\Tailblade\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

trait Utilities {

    /*
        |--------------------------------------------------------------------------
        | Utilities
        |--------------------------------------------------------------------------
        */

        /**
         * Get value from config file
         *
         * @param string $dotNotation
         * @param mixed $position
         * @return string
         */
        protected function getConfig(string $dotNotation, $position = null) {
            //Get array with values
            $array = Arr::get($this->config, $dotNotation);

            //Get all the values
            if(!$position) {
                return $array;
            }

            //Get current value or max value
            return $array[$position] ?? end($array);
        }

        /**
         * Generate the responsive behavior and the states
         *
         * @param array $arg
         * @return self
         */
        protected function addResponsiveAndStates(string $state, array $arg) : Collection
        {
            return collect($arg)
                ->each(function($class) use ($state) {
                    $this->classes[] = sprintf('%s:%s', $state, $class);
                });
        }
}
