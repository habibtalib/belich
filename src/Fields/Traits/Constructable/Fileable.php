<?php

namespace Daguilarm\Belich\Fields\Traits\Constructable;

use Daguilarm\Belich\Core\Belich;
use Daguilarm\Belich\Facades\Helper;
use Daguilarm\Belich\Fields\Field;
use Illuminate\Support\Facades\Storage;

trait Fileable
{
    /**
     * Resolve the avatar fields
     *
     * @param  Daguilarm\Belich\Fields\Field $field
     * @param  string $value
     */
    protected function resolveFile(Field $field, string $value)
    {
        if (!isset($value) || $value === Helper::emptyResults()) {
            return Helper::emptyResults();
        }

        //File policy
        return auth()->user()->can('file', Belich::getModel())
            ? $this->resolveFileType($field, $value)
            : false;
    }

    /**
     * Resolve the field by type
     *
     * @param  Daguilarm\Belich\Fields\Field $field
     * @param  string|null $value
     *
     * @return string
     */
    private function resolveFileType(Field $field, ?string $value): string
    {
        // Image field
        if ($field->fileType === 'image') {
            //Value is not an url get from storage
            $value = filter_var($value, FILTER_VALIDATE_URL)
                ? $value
                : Storage::disk($field->disk)->url($value);
            //Set the image alt
            $imageAlt = isset($field->alt) ? sprintf('alt="%s"', $field->alt) : '';
            //Set the css classes
            $imageCss = $field->addCss ?? 'block h-10 rounded-full shadow-md';

            return sprintf('<img class="%s" src="%s" %s>', $imageCss, $value, $imageAlt);
        }

        //Download file
        return sprintf('<a href="#">download</a>');
    }
}
