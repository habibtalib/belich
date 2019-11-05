<?php

namespace Daguilarm\Belich\Components\Helpers;

trait Paths
{
    /**
     * Get the package namespace path
     *
     * @param string $file
     *
     * @return string
     */
    public function namespace_path(string $file): string
    {
        return '\\Daguilarm\\Belich\\' . $file;
    }

    /**
     * Get the resource path
     *
     * @param string $file
     *
     * @return string
     */
    public function route_path(string $file): string
    {
        return sprintf('%s/%s', config('belich.path'), $file);
    }

    /**
     * Built belich urls
     *
     * @param string|null $resource
     *
     * @return string
     */
    public function belich_path(?string $resource = null): string
    {
        return sprintf(
            '%s%s/%s',
            config('belich.url'),
            config('belich.path'),
            $resource
        );
    }
}
