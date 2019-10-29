<?php

namespace Daguilarm\Belich\Fields\Traits\Constructable;

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
            //Set the image alt
            $imageAlt = !empty($field->alt) ? sprintf('alt="%s"', $field->alt) : '';
            //Set the css classes
            $imageCss = !empty($field->addCss) ? $field->addCss : 'block h-10 rounded-full shadow-md';

            return sprintf('<img class="%s" src="%s" %s>', $imageCss, $value, $imageAlt);
        }

        //Download file
        return sprintf('<a href="#">download</a>');
    }
}
