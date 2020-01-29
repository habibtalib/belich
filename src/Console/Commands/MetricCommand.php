<?php

namespace Daguilarm\Belich\Console\Commands;

use Daguilarm\Belich\Console\BelichCommand;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

final class MetricCommand extends BelichCommand
{
    /**
     * The name and signature of the console command.
     * RepoName in plural
     *
     * @var string
     */
    protected $signature = 'belich:metric {className}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new metric class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Metric';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        if (! File::exists($this->path())) {
            File::makeDirectory($this->path());
        }

        //Copy the file to folder while keeping the .stub extension
        (new Filesystem())->copy(
            $this->packgeStub(),
            $this->destinationStub()
        );

        // Replacements
        $this->replace('d_class_b', $this->argument('className'), $this->destinationStub());
        $this->replace('d_key_b', Str::kebab($this->argument('className')), $this->destinationStub());

        //Set the file
        (new Filesystem())->move(
            $this->destinationStub(),
            $this->destinationStub('php')
        );
    }

    /**
     * Get the stub file
     *
     * @return string
     */
    protected function packgeStub(): string
    {
        return __DIR__ . '/../../../../stubs/metric.stub';
    }

    /**
     * Get the stub file
     *
     * @return string
     */
    protected function path(): string
    {
        return app_path('Belich/Metrics');
    }

    /**
     * Set the stub destination
     *
     * @param string $ext
     *
     * @return string
     */
    protected function destinationStub(string $ext = 'stub'): string
    {
        return $this->path() . '/' . $this->argument('className') . '.' . $ext;
    }
}
