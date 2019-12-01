<?php

namespace Daguilarm\Belich\Components\Helpers;

use Illuminate\Support\HtmlString;
use Parsedown;

trait Markdown
{
    /**
     * Hide content base on screen size
     *
     * @param array $hideFor
     *
     * @return string
     */
    public function markdown(string $text): string
    {
        $markdown = app(Parsedown::class)
            ->setSafeMode(true)
            ->text($text);

        return nl2br($markdown);
    }
}
