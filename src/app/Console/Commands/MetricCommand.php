<?php

namespace Daguilarm\Belich\App\Console\Commands;

use Daguilarm\Belich\App\Console\BelichCommand;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class MetricCommand extends BelichCommand
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
     * Get the stub file
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/../../../stubs/metric.stub';
    }

    /**
     * Set the stub destination
     *
     * @return string
     */
    protected function setStub($ext = 'stub')
    {
        return app_path('Belich/Metrics/' . $this->argument('className') . '.' . $ext);
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        //Copy the file to folder while keeping the .stub extension
        (new Filesystem)->copy(
            $this->getStub(),
            $this->setStub()
        );

        // Replacements
        $this->replace('d_class_b', $this->argument('className'), $this->setStub());
        $this->replace('d_key_b', Str::kebab($this->argument('className')), $this->setStub());

        //Set the file
        (new Filesystem)->move(
            $this->setStub(),
            $this->setStub('php')
        );
    }
}
