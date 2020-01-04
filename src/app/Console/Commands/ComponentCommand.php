<?php

namespace Daguilarm\Belich\App\Console\Commands;

use Daguilarm\Belich\App\Console\BelichCommand;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;

final class ComponentCommand extends BelichCommand
{
    /**
     * The name and signature of the console command.
     * RepoName in plural
     *
     * @var string
     */
    protected $signature = 'belich:component {className}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new custom component';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Component';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        // Create directory if not exists
        if (! File::exists($this->path())) {
            File::makeDirectory($this->path());
        }

        // Create the main class
        $this->createClass();

        // Create the views
        $this->createViews();
    }

    /**
     * Create the main class
     *
     * @return void
     */
    protected function createClass(): void
    {
        $stub = $this->packgeStub('field');
        $destination = $this->destinationStub($this->argument('className'));

        //Copy the file to folder while keeping the .stub extension
        (new Filesystem())->copy(
            $stub,
            $destination
        );

        // Replacements
        $this->replace('d_class_b', $this->argument('className'), $destination);

        //Set the file
        (new Filesystem())->move(
            $destination,
            $this->destinationStub($this->argument('className'), 'php')
        );
    }

    /**
     * Create the main class
     *
     * @return void
     */
    protected function createViews(): void
    {
        // Create directory if not exists
        if (! File::exists($this->path() . '/resources')) {
            File::makeDirectory($this->path() . '/resources');
        }

        // Create directory if not exists
        if (! File::exists($this->path() . '/resources/views')) {
            File::makeDirectory($this->path() . '/resources/views');
        }

        $actions = ['create', 'edit', 'index', 'show'];
        // $stub = $this->packgeStub('views/');
        // $destination = $this->destinationStub('resources/views/');

        //Copy the file to folder while keeping the .stub extension
        foreach ($actions as $action) {
            (new Filesystem())->copy(
                $this->packgeStub('views/' . $action),
                $this->destinationStub('resources/views/' . $action)
            );

            // Replacements
            $this->replace('d_class_b', $this->argument('className'), $this->destinationStub('resources/views/' . $action));

            //Set the file
            (new Filesystem())->move(
                $this->destinationStub('resources/views/' . $action),
                $this->destinationStub('resources/views/' . $action, 'blade.php')
            );
        }
    }

    /**
     * Get the stub file
     *
     * @return string
     */
    protected function path(): string
    {
        return app_path('Belich/Components/' . $this->argument('className'));
    }

    /**
     * Get the stub file
     *
     * @return string
     */
    protected function packgeStub(string $file): string
    {
        return __DIR__ . '/../../../stubs/components/' . $file . '.stub';
    }

    /**
     * Set the stub destination
     *
     * @param string $ext
     *
     * @return string
     */
    protected function destinationStub(string $class, string $ext = 'stub'): string
    {
        return $this->path() . '/' . $class . '.' . $ext;
    }
}
