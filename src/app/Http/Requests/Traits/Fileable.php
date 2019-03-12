<?php

namespace Daguilarm\Belich\App\Http\Requests\Traits;

use Illuminate\Support\Facades\Storage;

// This trait is inspired by https://github.com/stahiralijan/request-caster/
trait Fileable {

    /**
    * Called by validate() method, it maps all the methods used to perform the operations
    * @return self
    */
    public function handleFile()
    {
        return collect($this->request->get('__file'))
            ->map(function($values, $key) {
                return $this->uploadFile($key, $values);
            });
    }

    /**
    * Upload file to storage
    *
    * @param string $attribute [Field name]
    * @param array $values
    * @return self
    */
    private function uploadFile($attribute, $values)
    {
        $file = $this->files->get($attribute);
        $fileName = $this->fileName($file, $values);

        if(Storage::disk($values['disk'])->put($fileName, $file)) {
            return $this->request->{$attribute} = $fileName;
        }

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
}
