<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Components\Helpers;

trait Messages
{
    /**
     * Get the message session
     */
    public function messages(string $type): array
    {
        return $type === 'errors'
            ? session()->get($type)->all()
            : session()->get($type);
    }
}
