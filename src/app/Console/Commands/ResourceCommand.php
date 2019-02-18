<?php

namespace Daguilarm\Belich\App\Console\Commands;

use Daguilarm\Belich\App\Console\BelichCommand;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class ResourceCommand extends BelichCommand
{
    /**
     * The name and signature of the console command.
     * RepoName in plural
     *
     * @var string
     */
    protected $signature = 'belich:resource {className}  {--model=} {--create}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new resource class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Resource';

    /**
     * Get the stub file
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/../../../stubs/resource.stub';
    }

    /**
     * Set the stub destination
     *
     * @return string
     */
    protected function setStub($ext = 'stub')
    {
        return app_path('Belich/Resources/' . $this->classModel() . '.' . $ext);
    }

    /**
     * Get the optional model path.
     *
     * @return string
     */
    protected function modelPath()
    {
        return $this->option('model') ?? 'App\\' . $this->className();
    }

    /**
     * Get the optional model namespace.
     *
     * @return string
     */
    protected function modelNamespace()
    {
        $namespace = str_replace('\\' . $this->className(), '', $this->modelPath());

        return $namespace === '\\App' ? 'App' : $namespace;
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
        $this->replace('d_model_b', $this->className(), $this->setStub());
        $this->replace('d_model_path_b', $this->modelPath(), $this->setStub());
        $this->replace('d_model_plural_b', Str::plural($this->className()), $this->setStub());

        //Set the file
        (new Filesystem)->move(
            $this->setStub(),
            $this->setStub('php')
        );

        //Create the model
        if($this->option('create')) {
            $this->createModel();
        }
    }

    public function createModel()
    {
        $storedStub = $this->calculateModel() . '.stub';
        $storedModel = $this->calculateModel() . '.php';

        //Copy the file to folder while keeping the .stub extension
        (new Filesystem)->copy(
            __DIR__ . '/../../../stubs/model.stub',
            $storedStub
        );

        // Replacements
        $this->replace('d_model_b', $this->className(), $storedStub);
        $this->replace('d_model_namespace_b', $this->modelNamespace(), $storedStub);

        //Set the file
        (new Filesystem)->move(
            $storedStub,
            $storedModel
        );
    }

    public function calculateModel()
    {
        $path = str_replace(['App'], 'app', $this->modelPath());
        $path = explode('\\', $path);

        return base_path(collect($path)->filter()->implode(DIRECTORY_SEPARATOR));
    }
}