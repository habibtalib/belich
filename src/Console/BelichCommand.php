<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

abstract class BelichCommand extends Command
{
    /**
     * Get the class type: Policy, Model, Controller,...
     */
    protected function classType(): string
    {
        return explode(':', Str::lower($this->argument('command')))[1];
    }

    /**
     * Get the class name.
     */
    protected function className(): string
    {
        $class = str_replace($this->classType(), '', Str::lower($this->argument('className')));

        return Str::title($class);
    }

    /**
     * Get the class name.
     */
    protected function classModel(): string
    {
        return ucfirst($this->argument('className'));
    }

    /**
     * Get the class name.
     */
    protected function classLower(): string
    {
        return strtolower($this->argument('className'));
    }

    /**
     * Get the class name.
     */
    protected function classSnake(): string
    {
        return Str::snake($this->classLower());
    }

    /**
     * Replace the given string in the given file.
     */
    protected function replace(string $search, string $replace, string $path): void
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }

    /**
     * Copy file from ... to ...
     */
    protected function copyFromTo(string $from, string $to)
    {
        $file = new Filesystem();

        $file->copy($from,$to);
    }

    /**
     * Move file from ... to ...
     */
    protected function moveFromTo(string $from, string $to)
    {
        $file = new Filesystem();

        $file->move($from,$to);
    }

    /**
     * Create a new directory if not exists...
     */
    protected function makeDirectory(string $folder)
    {
        if (! File::exists($folder)) {
            File::makeDirectory($folder);
        }
    }
}
