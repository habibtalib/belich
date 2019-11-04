<?php

namespace Daguilarm\Belich\Components\Helpers;

trait Files
{
    /**
     * Get the name from a file string [file.ext]
     *
     * @param string $fileName
     * @param bool $extension
     *
     * @return string
     */
    private function getFileAttributes(string $fileName, bool $extension = false): string
    {
        $str = explode('.', $fileName);

        return isset($str) && count($str) === 2
            ? ($extension ? $str[1] : $str[0])
            : Belich::emptyResults();
    }
}
