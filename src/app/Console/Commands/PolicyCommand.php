<?php

namespace Daguilarm\Belich\App\Console\Commands;

use Daguilarm\Belich\App\Console\BelichCommand;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class PolicyCommand extends BelichCommand
{
    /**
     * The name and signature of the console command.
     * RepoName in plural
     *
     * @var string
     */
    protected $signature = 'belich:policy {className}  {--model=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new policy class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Policy';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        if (!File::exists($this->path())) {
            File::makeDirectory($this->path());
        }

        //Copy the file to folder while keeping the .stub extension
        (new Filesystem())->copy(
            $this->getStub(),
            $this->setStub()
        );

        // Replacements
        $this->replace('d_model_b', $this->className(), $this->setStub());
        $this->replace('d_model_path_b', $this->modelPath(), $this->setStub());
        $this->replace('d_model_variable_b', Str::lower($this->className()), $this->setStub());
        $this->replace('d_model_user_path_b', config('auth.providers.users.model'), $this->setStub());

        //Set the file
        (new Filesystem())->move(
            $this->setStub(),
            $this->setStub('php')
        );
    }

    /**
     * Get the stub file
     *
     * @return string
     */
    protected function getStub(): string
    {
        return __DIR__ . '/../../../stubs/policy.stub';
    }

    /**
     * Get the stub file
     *
     * @return string
     */
    protected function path(): string
    {
        return app_path('Policies');
    }

    /**
     * Set the stub destination
     *
     * @return string
     */
    protected function setStub($ext = 'stub'): string
    {
        return $this->path() . '/' . $this->classModel() . '.' . $ext;
    }

    /**
     * Get the optional model path.
     *
     * @return string
     */
    protected function modelPath(): string
    {
        return $this->option('model') ?? '\\App\\' . $this->className();
    }
}
