<?php

namespace Daguilarm\Belich\Components\Helpers;

trait Files
{
    /**
     * Get the name from a file string [file.ext]
     */
    public function getFileAttributes(string $fileName, bool $extension = false): string
    {
        $str = explode('.', $fileName);

        return isset($str) && count($str) === 2
            ? ($extension ? $str[1] : $str[0])
            : Belich::emptyResults();
    }
}
