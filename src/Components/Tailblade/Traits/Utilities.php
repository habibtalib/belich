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
        protected function getConfig(string $dotNotation, $position = null, $default = '') {
            //Get array with values
            $array = Arr::get($this->config, $dotNotation);

            //Get all the values
            if(!$position) {
                return $array;
            }

            //Set default
            $default = $default
                ? $default
                : end($array);

            //Get current value or max value
            return $array[$position] ?? $default;
        }

        /**
         * Check if the a value exists in the config file or return a default
         *
         * @param string $dotNotation
         * @param mixed $search
         * @return string
         */
        protected function getValidateConfig(string $dotNotation, $search, $default = '') : string
        {
            //Get array with values
            $array = Arr::get($this->config, $dotNotation);

            //Verify the value exists
            return in_array($search, $array)
                ? $search
                : $default;
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
