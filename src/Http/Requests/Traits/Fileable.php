<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Http\Requests\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\ParameterBag;

trait Fileable
{
    /**
     * Called by validate() method, it maps all the methods used to perform the operations
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
     */
    private function storeFile(string $attribute, ?object $file, ?object $model, array $values): ?string
    {
        //Get default values
        $fileName = $values[$attribute];
        $disk = $values['disk'];

        //Upload file
        if (Storage::disk($disk)->put($fileName, $this->getFileContent($file))) {
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
     */
    private function fileName(object $file): string
    {
        $extension = $file->getClientOriginalExtension();
        $name = Str::random(5) . time();

        return sprintf('%s.%s', $name, $extension);
    }

    /**
     * Get file content
     */
    private function getFileContent(?object $file): string
    {
        return file_get_contents($file->getRealPath());
    }

    /**
     * Store file
     */
    private function getVariables(string $attribute, array $fileAttributes, string $fileName, object $fileObject, array $values): array
    {
        return [
            $attribute => $fileName,
            $values['storeSize'] => $this->getVariablesStoreSize($fileAttributes, $fileObject),
            $values['storeName'] => $this->getVariablesStoreName($fileAttributes, $fileObject),
            $values['storeMime'] => $this->getVariablesStoreMime($fileAttributes, $fileObject),
            'disk' => $this->getVariablesStoreDisk($attribute, $fileAttributes),
        ];
    }

    /**
     * Get the file size for storage
     *
     * @return  string|float|int|null
     */
    private function getVariablesStoreSize(array $attributes, object $file)
    {
        return $attributes['storeSize']
            ? $file->getSize()
            : null;
    }

    /**
     * Get the file name for storage
     */
    private function getVariablesStoreName(array $attributes, object $file): ?string
    {
        return $attributes['storeName']
            ? $file->getClientOriginalName()
            : null;
    }

    /**
     * Get the file mime for storage
     */
    private function getVariablesStoreMime(array $attributes, object $file): ?string
    {
        return $attributes['storeMime']
            ? $file->getMimeType()
            : null;
    }

    /**
     * Get the storage disk
     */
    private function getVariablesStoreDisk(string $attribute, array $attributes): string
    {
        return $attributes[$attribute]['disk'] ?? 'public';
    }

    /**
     * Delete previus file
     */
    private function deletePrevius(string $attribute, string $disk, ?object $model): void
    {
        if ($this->isObjectModel($model)) {
            // Table column to delete
            $table = $model->{$attribute};
            // Delete the previus file from storage
            Storage::disk($disk)->delete($table);
        }
    }

    /**
     * Check for the file
     */
    private function isEmtpyFile(?object $file): bool
    {
        return isset($file) && $file;
    }

    /**
     * Check for the file
     */
    private function isObjectModel(?object $model): bool
    {
        return isset($model) && $model && is_object($model);
    }
}
