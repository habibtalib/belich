<?php

namespace Daguilarm\Belich\App\Console\Commands;

use Daguilarm\Belich\App\Console\BelichCommand;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class CardCommand extends BelichCommand
{
    /**
     * The name and signature of the console command.
     * RepoName in plural
     *
     * @var string
     */
    protected $signature = 'belich:card {className} {--view}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new card class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Card';

    /**
     * Get the stub file
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/../../../stubs/card.stub';
    }

    /**
     * Get the stub file
     *
     * @return string
     */
    protected function path()
    {
        return app_path('Belich/Cards/');
    }

    /**
     * Get the stub view file
     *
     * @return string
     */
    protected function getStubView()
    {
        return __DIR__ . '/../../../stubs/card_view.stub';
    }

    /**
     * Set the stub destination
     *
     * @return string
     */
    protected function setStub($ext = 'stub')
    {
        return $this->path() . $this->argument('className') . '.' . $ext;
    }

    /**
     * Set the stub view destination
     *
     * @return string
     */
    protected function setStubView($ext = 'stub')
    {
        return app_path('resources/views/vendor/belich/cards/' . $this->argument('className') . '.' . $ext);
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if(!File::exists($this->path())) {
            File::makeDirectory($this->path());
        }

        $this->handleClass();

        if($this->option('view')) {
            //Second the view
            $this->handleView();
        }
    }

    /**
     * Handle the class
     *
     * @return void
     */
    protected function handleClass()
    {
        if(!File::exists($this->path())) {
            File::makeDirectory($this->path());
        }

        //Copy the file to folder while keeping the .stub extension
        (new Filesystem)->copy(
            $this->getStub(),
            $this->setStub()
        );

        // Replacements
        $this->replace('d_class_b', $this->argument('className'), $this->setStub());
        $this->replace('d_key_b', Str::kebab($this->argument('className')), $this->setStub());
        $this->replace('d_view_b', $this->classSnake(), $this->setStub());

        //Set the file
        (new Filesystem)->move(
            $this->setStub(),
            $this->setStub('php')
        );
    }

    /**
     * Handle the view
     *
     * @return void
     */
    protected function handleView()
    {
        $path = app_path('resources/views/vendor/belich/cards');

        if(!File::exists($path)) {
            File::makeDirectory($path);
        }

        //Copy the file to folder while keeping the .stub extension
        (new Filesystem)->copy(
            $this->getStubView(),
            $this->setStubView()
        );

        // Replacements
        $this->replace('d_class_b', $this->argument('className'), $this->setStubView());
        $this->replace('d_key_b', Str::kebab($this->argument('className')), $this->setStubView());
        $this->replace('d_view_b', $this->classSnake(), $this->setStubView());

        //Set the file
        (new Filesystem)->move(
            $this->setStubView(),
            $this->setStubView('php')
        );
    }
}
