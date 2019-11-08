<?php

namespace Daguilarm\Belich\App\Http\Requests\Traits;

use Illuminate\Support\Arr;
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
        $fileAttributes = $this->request->get('__file');

        //Upload the files
        collect($fileAttributes)
            // Values contain all the hidden field values
            ->map(function ($values, $key) use ($fileAttributes, $model) {
                return $this->uploadFile($key, $model, $values, $fileAttributes);
            });

        return $this->request;
    }

    /**
     * Upload file to storage
     *
     * @param string $attribute [Field name]
     * @param object|null $model
     * @param array $values
     * @param array $fileAttributes
     *
     * @return void
     */
    private function uploadFile(string $attribute, ?object $model, array $values, array $fileAttributes): void
    {
        // Get the file object
        $fileObject = $this->{$attribute};

        //Not file uploaded
        if (is_null($fileObject)) {
            return;
        }

        // Get default values
        $fileName = $this->fileName($fileObject);

        // Get the file attributes
        $fileAttributes = $fileAttributes[$attribute];

        // Update the parameters
        $values = $this->getVariables($attribute, $fileAttributes, $fileName, $fileObject, $values);

        //Upload the file
        if (is_object($fileObject)) {
            // Store file
            $this->storeFile($attribute, $fileObject, $model, $values);
        }

        //Keep the current file if not updated or change...
        $this->request->add($values);
    }

    /**
     * Store file
     *
     * @param string $attribute
     * @param object|null $file
     * @param object|null $model
     * @param array $values
     *
     * @return string|null
     */
    private function storeFile(string $attribute, ?object $file, ?object $model, array $values): ?string
    {
        //Get default values
        $fileName = $values[$attribute];
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
     *
     * @return string
     */
    private function fileName(object $file): string
    {
        $extension = $file->getClientOriginalExtension();
        $name = time() . basename($file);

        return sprintf('%s.%s', $name, $extension);
    }

    /**
     * Store file
     *
     * @param string $attribute
     * @param array $fileAttributes
     * @param string $fileName
     * @param object $fileObject
     * @param array $values
     *
     * @return array
     */
    private function getVariables(string $attribute, array $fileAttributes, string $fileName, object $fileObject, array $values): array
    {
        return [
            $attribute => empty($fileObject) ? $model->{$attribute} : $fileName,
            $values['storeSize'] => $fileAttributes['storeSize'] ? $fileObject->getSize() : null,
            $values['storeName'] => $fileAttributes['storeName'] ? $fileObject->getClientOriginalName() : null,
            $values['storeMime'] => $fileAttributes['storeMime'] ? $fileObject->getMimeType() : null,
            'disk' => $fileAttributes[$attribute]['disk'] ?? 'public',
        ];
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
