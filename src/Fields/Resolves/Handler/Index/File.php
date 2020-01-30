<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Resolves\Handler\Index;

use Daguilarm\Belich\Core\Belich;
use Daguilarm\Belich\Facades\Helper;
use Daguilarm\Belich\Fields\Field;
use Illuminate\Support\Facades\Storage;

final class File
{
    /**
     * Resolve file fields for Index and Show
     */
    public function handle(Field $field, ?string $value): string
    {
        // No results
        if (! isset($value) || $value === Helper::emptyResults()) {
            return Helper::emptyResults();
        }

        //File policy
        return auth()->user()->can('file', Belich::getModel())
            ? $this->byType($field, $value)
            : '';
    }

    /**
     * Resolve the field by type
     */
    private function byType(Field $field, ?string $value): string
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
                    'alt' => $imageAlt,
                ])->render();
            }
        }

        //Return file value
        return $value
            //With download or not
            ? sprintf('%s %s', $value, $this->download($field, $value))
            //With empty value
            : Helper::emptyResults();
    }

    /**
     * Download file
     */
    private function download(Field $field, ?string $file): string
    {
        $href = sprintf(
            '<a href="%s" target="_blank" dusk="downloable-file">%s</a>',
            $file,
            Helper::icon('b-download')
        );

        return $field->link && $file
            ? $href
            : '';
    }
}
