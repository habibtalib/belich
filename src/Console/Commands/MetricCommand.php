<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Console\Commands;

use Daguilarm\Belich\Console\BelichCommand;
use Illuminate\Support\Str;

final class MetricCommand extends BelichCommand
{
    protected $signature = 'belich:metric {className}';
    protected $description = 'Create a new metric class';
    protected $type = 'Metric';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // Create directory if not exists
        $this->makeDirectory($this->path());

        //Copy the file to folder while keeping the .stub extension
        $this->copyFromTo(
            $this->packgeStub(),
            $this->destinationStub()
        );

        // Replacements
        $this->replace('d_class_b', $this->argument('className'), $this->destinationStub());
        $this->replace('d_key_b', Str::kebab($this->argument('className')), $this->destinationStub());

        //Set the file
        $this->moveFromTo(
            $this->destinationStub(),
            $this->destinationStub('php')
        );
    }

    /**
     * Get the stub file
     */
    protected function packgeStub(): string
    {
        return __DIR__ . '/../../../stubs/metric.stub';
    }

    /**
     * Get the stub file
     */
    protected function path(): string
    {
        return app_path('Belich/Metrics');
    }

    /**
     * Set the stub destination
     */
    protected function destinationStub(string $ext = 'stub'): string
    {
        return $this->path() . '/' . $this->argument('className') . '.' . $ext;
    }
}
