<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Console\Commands;

use Daguilarm\Belich\Console\BelichCommand;
use Illuminate\Support\Str;

final class ResourceCommand extends BelichCommand
{
    protected $signature = 'belich:resource {className}  {--model=} {--create}';
    protected $description = 'Create a new resource class';
    protected $type = 'Resource';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // Create directory if not exists
        $this->makeDirectory($this->path());

        //Copy the file to folder while keeping the .stub extension
        $this->copyFromTo(
            $this->packageStub(),
            $this->destinationStub()
        );

        // Replacements
        $this->replace('d_model_b', $this->className(), $this->destinationStub());
        $this->replace('d_model_path_b', $this->modelPath(), $this->destinationStub());
        $this->replace('d_model_plural_b', Str::plural($this->className()), $this->destinationStub());

        //Set the file
        $this->moveFromTo(
            $this->destinationStub(),
            $this->destinationStub('php')
        );

        //Create the model
        if ($this->option('create')) {
            $this->createModel();
        }
    }

    /**
     * Create model
     */
    protected function createModel(): void
    {
        $storedStub = $this->calculateModel() . '.stub';
        $storedModel = $this->calculateModel() . '.php';

        //Copy the file to folder while keeping the .stub extension
        $this->copyFromTo(
            __DIR__ . '/../../../stubs/model.stub',
            $storedStub
        );

        // Replacements
        $this->replace('d_model_b', $this->className(), $storedStub);
        $this->replace('d_model_namespace_b', $this->modelNamespace(), $storedStub);

        //Set the file
        $this->moveFromTo(
            $storedStub,
            $storedModel
        );
    }

    /**
     * Calculate model
     */
    protected function calculateModel(): string
    {
        $path = str_replace(['App'], 'app', $this->modelPath());
        $path = explode('\\', $path);

        return base_path(collect($path)->filter()->implode(DIRECTORY_SEPARATOR));
    }

    /**
     * Get the stub file
     */
    protected function packageStub(): string
    {
        return __DIR__ . '/../../../stubs/resource.stub';
    }

    /**
     * Get the stub file
     */
    protected function path(): string
    {
        return app_path('Belich/Resources');
    }

    /**
     * Set the stub destination
     */
    protected function destinationStub(string $ext = 'stub'): string
    {
        return $this->path() . '/' . $this->classModel() . '.' . $ext;
    }

    /**
     * Get the optional model path.
     */
    protected function modelPath(): string
    {
        return $this->option('model') ?? 'App\\' . $this->className();
    }

    /**
     * Get the optional model namespace.
     */
    protected function modelNamespace(): string
    {
        $namespace = str_replace('\\' . $this->className(), '', $this->modelPath());

        return $namespace === '\\App' ? 'App' : $namespace;
    }
}
