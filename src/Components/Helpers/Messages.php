<?php

namespace Daguilarm\Belich\Components\Helpers;

trait Messages
{
    /**
     * Get the message session
     *
     * @return array
     */
    private function messages(string $type): array
    {
        return $type === 'errors'
            ? session()->get($type)->all()
            : session()->get($type);
    }
}
