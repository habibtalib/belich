<?php

namespace Daguilarm\Belich\App\Console\Commands;

use Daguilarm\Belich\App\Console\BelichCommand;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

final class CardCommand extends BelichCommand
{
    /**
     * The name and signature of the console command.
     * RepoName in plural
     *
     * @var string
     */
    protected $signature = 'belich:card {className}';

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
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        if (! File::exists($this->path())) {
            File::makeDirectory($this->path());
        }

        $this->handleClass();
    }

    /**
     * Handle the class
     *
     * @return void
     */
    protected function handleClass(): void
    {
        if (! File::exists($this->path())) {
            File::makeDirectory($this->path());
        }

        //Create view directory
        $viewsFolder = explode('/', $this->configPathForView());
        $parentFolder = '';
        foreach ($viewsFolder as $folder) {
            $parentFolder .= $folder . '/';
            if (! File::exists($parentFolder)) {
                File::makeDirectory($parentFolder);
            }
        }

        //Copy the file to folder while keeping the .stub extension
        (new Filesystem())->copy(
            $this->packgeStub(),
            $this->destinationStub()
        );

        //Copy the view file to folder while keeping the .stub extension
        (new Filesystem())->copy(
            $this->packgeStubView(),
            $this->destinationStubView()
        );

        // Replacements
        $this->replace('d_class_b', $this->argument('className'), $this->destinationStub());
        $this->replace('d_key_b', Str::kebab($this->argument('className')), $this->destinationStub());
        $this->replace('d_view_b', Str::snake($this->argument('className')), $this->destinationStub());

        //Set the file
        (new Filesystem())->move(
            $this->destinationStub(),
            $this->destinationStub('php')
        );

        //Set the file for view
        (new Filesystem())->move(
            $this->destinationStubView(),
            $this->destinationStubView('php')
        );
    }

    /**
     * Get the stub file
     *
     * @return string
     */
    protected function packgeStub(): string
    {
        return __DIR__ . '/../../../stubs/card.stub';
    }

    /**
     * Get the stub view file
     *
     * @return string
     */
    protected function packgeStubView(): string
    {
        return __DIR__ . '/../../../stubs/card-view.stub';
    }

    /**
     * Get the stub file
     *
     * @return string
     */
    protected function path(): string
    {
        return app_path('Belich/Cards/');
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
        return $this->path() . $this->argument('className') . '.' . $ext;
    }

    /**
     * Set the stub destination for the view
     *
     * @param string $ext
     *
     * @return string
     */
    protected function destinationStubView(string $ext = 'stub'): string
    {
        return $this->configPathForView() . $this->argument('className') . '.' . $ext;
    }

    /**
     * Get the config path for view storage
     *
     * @param string $ext
     *
     * @return string
     */
    protected function configPathForView(): string
    {
        $path = config('belich.cards.path');

        return Str::endsWith($path, '/')
            ? $path
            : $path . '/';
    }
}
