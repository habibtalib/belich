<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Console\Commands;

use Daguilarm\Belich\Console\BelichCommand;

final class ComponentCommand extends BelichCommand
{
    protected string $signature = 'belich:component {className}';
    protected string $description = 'Create a new custom component';
    protected string $type = 'Component';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // Create directory if not exists
        $this->makeDirectory($this->path());

        // Create the main class
        $this->createClass();

        // Create the views
        $this->createViews();
    }

    /**
     * Create the main class
     */
    protected function createClass(): void
    {
        $stub = $this->packgeStub('field');
        $destination = $this->destinationStub($this->argument('className'));

        //Copy the file to folder while keeping the .stub extension
        $this->copyFromTo(
            $stub,
            $destination
        );

        // Replacements
        $this->replace('d_class_b', $this->argument('className'), $destination);

        //Set the file
        $this->moveFromTo(
            $destination,
            $this->destinationStub($this->argument('className'), 'php')
        );
    }

    /**
     * Create the main class
     */
    protected function createViews(): void
    {
        // Create directory if not exists
        $this->makeDirectory($this->path() . '/resources');

        // Create directory if not exists
        $this->makeDirectory($this->path() . '/resources/views');

        $actions = ['create', 'edit', 'index', 'show'];
        // $stub = $this->packgeStub('views/');
        // $destination = $this->destinationStub('resources/views/');

        //Copy the file to folder while keeping the .stub extension
        foreach ($actions as $action) {
            $this->copyFromTo(
                $this->packgeStub('views/' . $action),
                $this->destinationStub('resources/views/' . $action)
            );

            // Replacements
            $this->replace('d_class_b', $this->argument('className'), $this->destinationStub('resources/views/' . $action));

            //Set the file
            $this->moveFromTo(
                $this->destinationStub('resources/views/' . $action),
                $this->destinationStub('resources/views/' . $action, 'blade.php')
            );
        }
    }

    /**
     * Get the stub file
     */
    protected function path(): string
    {
        return app_path('Belich/Components/' . $this->argument('className'));
    }

    /**
     * Get the stub file
     */
    protected function packgeStub(string $file): string
    {
        return __DIR__ . '/../../../stubs/components/' . $file . '.stub';
    }

    /**
     * Set the stub destination
     */
    protected function destinationStub(string $class, string $ext = 'stub'): string
    {
        return $this->path() . '/' . $class . '.' . $ext;
    }
}
