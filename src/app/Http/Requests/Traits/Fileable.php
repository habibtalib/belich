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
        return collect($this->request->get('__file'))
            ->map(function($values, $key) use ($model) {
                return $this->uploadFile($key, $values, $model);
            });
    }

    /**
    * Upload file to storage
    *
    * @param string $attribute [Field name]
    * @param array $values
    * @param object $model
    * @return self
    */
    private function uploadFile(string $attribute, array $values, $model)
    {
        //Default values
        list($file, $fileName, $disk) = $this->fileAttributes($attribute, $values);

        //Upload file
        if(Storage::disk($disk)->put($fileName, $file)) {
            //Delete the previus file from storage
            $this->deletePrevius($attribute, $disk, $model);

            return $this->request->{$attribute} = $fileName;
        }

        return $this->request->{$attribute} = null;
    }

    /**
    * File attributes
    *
    * @param string $attribute [Field name]
    * @param array $values
    * @return array
    */
    private function fileAttributes(string $attribute, array $values) : array
    {
        $file = $this->{$attribute};

        return [
            file_get_contents($file->getRealPath()),
            $this->fileName($file, $values),
            $values['disk'],
        ];
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
        if($model) {
            $previus = $model->{$attribute};
            $delete = Storage::disk($disk)->delete($previus);
        }
    }
}
