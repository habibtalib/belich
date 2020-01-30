<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Console\Commands;

use Daguilarm\Belich\Console\BelichCommand;
use Illuminate\Support\Str;

final class PolicyCommand extends BelichCommand
{
    protected $signature = 'belich:policy {className}  {--model=}';
    protected $description = 'Create a new policy class';
    protected $type = 'Policy';

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
        $this->replace('d_model_variable_b', Str::lower($this->className()), $this->destinationStub());
        $this->replace('d_model_user_path_b', config('auth.providers.users.model'), $this->destinationStub());

        //Set the file
        $this->moveFromTo(
            $this->destinationStub(),
            $this->destinationStub('php')
        );
    }

    /**
     * Get the stub file
     */
    protected function packageStub(): string
    {
        return __DIR__ . '/../../../stubs/policy.stub';
    }

    /**
     * Get the stub file
     */
    protected function path(): string
    {
        return app_path('Policies');
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
        return $this->option('model') ?? '\\App\\' . $this->className();
    }
}
