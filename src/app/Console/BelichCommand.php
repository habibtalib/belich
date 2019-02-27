<?php

namespace Daguilarm\Belich\App\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

abstract class BelichCommand extends Command
{
    /**
     * Get the class type: Policy, Model, Controller,...
     *
     * @return string
     */
    protected function classType()
    {
        return explode(':', Str::lower($this->argument('command')))[1];
    }

    /**
     * Get the class name.
     *
     * @return string
     */
    protected function className()
    {
        $class = str_replace($this->classType(), '', Str::lower($this->argument('className')));

        return Str::title($class);
    }

    /**
     * Get the class name.
     *
     * @return string
     */
    protected function classModel()
    {
        return ucfirst($this->argument('className'));
    }

    /**
     * Get the class name.
     *
     * @return string
     */
    protected function classLower()
    {
        return strtolower($this->argument('className'));
    }

    /**
     * Get the class name.
     *
     * @return string
     */
    protected function classSnake()
    {
        return Str::snake($this->classLower());
    }

    /**
     * Replace the given string in the given file.
     *
     * @param  string  $search
     * @param  string  $replace
     * @param  string  $path
     * @return void
     */
    protected function replace($search, $replace, $path)
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }
}
