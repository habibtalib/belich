<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Console\Commands;

use Daguilarm\Belich\Console\BelichCommand;
use Illuminate\Support\Str;

final class CardCommand extends BelichCommand
{
    protected $signature = 'belich:card {className}';
    protected $description = 'Create a new card class';
    protected $type = 'Card';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // Create the default directory
        $this->makeDirectory($this->path());

        // Handle commands
        $this->handleClass();
    }

    /**
     * Handle the class
     */
    protected function handleClass(): void
    {
        //Create view directory
        $viewsFolder = explode('/', $this->configPathForView());
        $parentFolder = '';
        foreach ($viewsFolder as $folder) {
            $parentFolder .= $folder . '/';
            $this->makeDirectory($parentFolder);
        }

        //Copy the file to folder while keeping the .stub extension
        $this->copyFromTo(
            $this->packgeStub(),
            $this->destinationStub()
        );

        //Copy the view file to folder while keeping the .stub extension
        $this->copyFromTo(
            $this->packgeStubView(),
            $this->destinationStubView()
        );

        // Replacements
        $this->replace('d_class_b', $this->argument('className'), $this->destinationStub());
        $this->replace('d_key_b', Str::kebab($this->argument('className')), $this->destinationStub());
        $this->replace('d_view_b', Str::snake($this->argument('className')), $this->destinationStub());

        //Set the file
        $this->moveFromTo(
            $this->destinationStub(),
            $this->destinationStub('php')
        );

        //Set the file for view
        $this->moveFromTo(
            $this->destinationStubView(),
            $this->destinationStubView('php')
        );
    }

    /**
     * Get the stub file
     */
    protected function packgeStub(): string
    {
        return __DIR__ . '/../../../stubs/card.stub';
    }

    /**
     * Get the stub view file
     */
    protected function packgeStubView(): string
    {
        return __DIR__ . '/../../../stubs/card-view.stub';
    }

    /**
     * Get the stub file
     */
    protected function path(): string
    {
        return app_path('Belich/Cards/');
    }

    /**
     * Set the stub destination
     */
    protected function destinationStub(string $ext = 'stub'): string
    {
        return $this->path() . $this->argument('className') . '.' . $ext;
    }

    /**
     * Set the stub destination for the view
     */
    protected function destinationStubView(string $ext = 'stub'): string
    {
        return $this->configPathForView() . $this->argument('className') . '.' . $ext;
    }

    /**
     * Get the config path for view storage
     */
    protected function configPathForView(): string
    {
        $path = config('belich.cards.path');

        return Str::endsWith($path, '/')
            ? $path
            : $path . '/';
    }
}
