<?php

namespace Daguilarm\Belich\Fields\Traits\Indexable;

use Daguilarm\Belich\Core\Belich;
use Daguilarm\Belich\Fields\Field;
use Illuminate\Support\Facades\Storage;

trait Fileable {

    /**
     * Resolve the avatar fields
     *
     * @param  Daguilarm\Belich\Fields\Field $field
     * @param  string $value
     * @return mixed
     */
    protected function resolveFile(Field $field, string $value)
    {
        if(empty($value) || $value === emptyResults()) {
            return emptyResults();
        }

        //File policy
        if(auth()->user()->can('file', Belich::getModel())) {
            // Image by type
            return $this->resolveFileType($field, $value);
        }
    }

    /**
     * Resolve the field by type
     *
     * @param  Daguilarm\Belich\Fields\Field $field
     * @param  mixed $value
     * @return string
     */
    private function resolveFileType(Field $field, $value) : string
    {
        // Image field
        if($field->fileType === 'image') {
            //Value is not an url
            if(!filter_var($value, FILTER_VALIDATE_URL)) {
                $value = Storage::disk($field->disk)->url($value);
            }

            return sprintf('<img class="block h-10 rounded-full shadow-md" src="%s" alt="avatar">', $value);
        }

        //Download file
        return sprintf('<a href="#">download</a>');
    }
}
