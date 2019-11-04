<?php

namespace Daguilarm\Belich\App\Http\Requests\Traits;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\ParameterBag;

// This trait is inspired by https://github.com/stahiralijan/request-caster/
trait Fileable
{
    /**
     * Called by validate() method, it maps all the methods used to perform the operations
     *
     * @param object|null $model
     *
     * @return Symfony\Component\HttpFoundation\ParameterBag
     */
    public function handleFile(?object $model = null): ParameterBag
    {
        $file = $this->request->get('__file');

        //Upload the files
        collect($file)
            ->map(function ($values, $key) use ($model) {
                return $this->uploadFile($key, $model, $values);
            });

        return $this->request;
    }

    /**
     * Upload file to storage
     *
     * @param string $attribute [Field name]
     * @param object|null $model
     * @param array $values
     *
     * @return void
     */
    private function uploadFile(string $attribute, ?object $model, array $values): void
    {
        //Get the file
        $file = $this->{$attribute};

        //Upload the file
        if (is_object($file)) {
            $this->storeFile($attribute, $file, $model, $values);
        }

        //Keep the current file if not updated or change...
        $this->request->add([
            $attribute => is_null($file) ? $model->{$attribute} : $this->request->{$attribute}
        ]);
    }

    /**
     * Store file
     *
     * @param string $attribute
     * @param object|null $file
     * @param array $values
     * @param object|null $model
     * @param array $values
     *
     * @return string|null
     */
    private function storeFile(string $attribute, ?object $file, ?object $model, array $values): ?string
    {
        //Get default values
        $fileName = $this->fileName($file, $values);
        $disk = $values['disk'];

        //Upload file
        if (Storage::disk($disk)->put($fileName, file_get_contents($file))) {
            //Delete the previus file from storage
            $this->deletePrevius($attribute, $disk, $model);

            //Update request attribute value
            return $this->request->{$attribute} = $fileName;
        }

        //Empty attribute
        return $this->request->{$attribute} = null;
    }

    /**
     * File name
     *
     * @param object $file
     * @param array $values
     *
     * @return string
     */
    private function fileName(object $file, array $values): string
    {
        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $name = time() . basename($file);

        return $values['originalName']
            ? $originalName
            : sprintf('%s.%s', $name, $extension);
    }

    /**
     * Delete previus file
     *
     * @param string $attribute
     * @param string $disk
     * @param object|null $model
     *
     * @return void
     */
    private function deletePrevius(string $attribute, string $disk, ?object $model): void
    {
        //Delete the previus file from storage
        if (isset($model) && is_object($model)) {
            Storage::disk($disk)
                ->delete($model->{$attribute});
        }
    }
}
