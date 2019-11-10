<?php

namespace Daguilarm\Belich\Fields\Traits\Constructable;

use Daguilarm\Belich\Core\Belich;
use Daguilarm\Belich\Facades\Helper;
use Daguilarm\Belich\Fields\Field;
use Illuminate\Support\Facades\Storage;

trait Fileable
{
    /**
     * Resolve file fields for Index and Show
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

            if ($field->renderImage) {
                //Set the image alt
                $imageAlt = isset($field->alt) ? sprintf('alt="%s"', $field->alt) : '';

                return view('belich::components.thumbnails', [
                    'url' => $value,
                    'alt' => $imageAlt
                ])->render();
            }
        }

        //Return file value
        return $value
            //With download or not
            ? sprintf('%s %s', $value, $this->fileDownload($field, $value))
            //With empty value
            : Helper::emptyResults();
    }

    /**
     *Download file
     *
     * @param  Daguilarm\Belich\Fields\Field $field
     * @param  string|null $file
     *
     * @return string
     */
    private function fileDownload(Field $field, ?string $file)
    {
        if ($field->downloadable && $file) {
            return sprintf(
                '<a href="%s" target="_blank" dusk="downloadable-file">%s</a>',
                $file,
                Helper::icon('download'),
            );
        }
    }
}
