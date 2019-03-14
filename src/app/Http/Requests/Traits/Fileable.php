<?php

namespace Daguilarm\Belich\App\Http\Requests\Traits;

use Illuminate\Support\Facades\Storage;

// This trait is inspired by https://github.com/stahiralijan/request-caster/
trait Fileable {

    /**
    * Called by validate() method, it maps all the methods used to perform the operations
    * @param object $model
    * @return self
    */
    public function handleFile($model = null)
    {
        $file = $this->request->get('__file');

        return collect($file)
            ->map(function($values, $key) use ($model) {
                return $this->uploadFile($key, $model, $values);
            });
    }

    /**
    * Upload file to storage
    *
    * @param string $attribute [Field name]
    * @param array $values
    * @param null|object $model
    * @return self
    */
    private function uploadFile(string $attribute, $model, array $values)
    {
        //Get the file
        $file = $this->{$attribute};

        //Upload the file
        if(is_object($file)) {
            return $this->storeFile($attribute, $file, $model, $values);
        }

        //Keep the current file if not updated...
        if(is_object($model)) {
            return $this->request->{$attribute} = $model->{$attribute};
        }
    }

    /**
    * Store file
    *
    * @param null|object $file
    * @param array $values
    * @param null|object $model
    * @return null|string
    */
    private function storeFile(string $attribute, $file, $model, array $values)
    {
        //Get default values
        $fileName = $this->fileName($file, $values);
        $disk = $values['disk'];

        //Upload file
        if(Storage::disk($disk)->put($fileName, file_get_contents($file))) {
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
    * @return string
    */
    private function fileName(object $file, array $values) : string
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
    * @param object $model
    * @return void
    */
    private function deletePrevius(string $attribute, string $disk, $model) : void
    {
        //Delete the previus file from storage
        if(!empty($model) && is_object($model)) {
            $previus = $model->{$attribute};
            $delete = Storage::disk($disk)->delete($previus);
        }
    }
}
