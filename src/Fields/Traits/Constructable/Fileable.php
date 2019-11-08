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
     * @param  string|null $value
     *
     * @return  $string
     */
    protected function resolveFile(Field $field, ?string $value): string
    {
        // No results
        if (!isset($value) || $value === Helper::emptyResults()) {
            return Helper::emptyResults();
        }

        //File policy
        return auth()->user()->can('file', Belich::getModel())
            ? $this->resolveFileType($field, $value)
            : '';
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
            $value = Helper::validateUrl($value)
                ? $value
                : Storage::disk($field->disk)->url($value);

            if($field->render()) {
                //Set the image alt
                $imageAlt = isset($field->alt) ? sprintf('alt="%s"', $field->alt) : '';

                //Set the css classes
                $imageCss = $field->addCss ?? 'block h-10 rounded-full shadow-md';

                return sprintf('<img class="%s" src="%s" %s>', $imageCss, $value, $imageAlt);
            }

            return $value;
        }

        //Download file
        return $value
            ? sprintf('%s <a href="%s" target="_blank">%s</a>', $value, $value, Helper::icon('download'))
            : Helper::emptyResults();
    }
}
