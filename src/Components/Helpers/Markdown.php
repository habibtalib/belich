<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Components\Helpers;

use Parsedown;

trait Markdown
{
    /**
     * Format to markdown
     */
    public function markdown(?string $text): string
    {
        $markdown = app(Parsedown::class)
            ->setSafeMode(true)
            ->text($text);

        return $text
            ? nl2br($markdown)
            : '';
    }
}
