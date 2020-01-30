<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Components;

use Daguilarm\Belich\Components\Helpers\Blade;
use Daguilarm\Belich\Components\Helpers\Currency;
use Daguilarm\Belich\Components\Helpers\Files;
use Daguilarm\Belich\Components\Helpers\Forms;
use Daguilarm\Belich\Components\Helpers\Gravatar;
use Daguilarm\Belich\Components\Helpers\Markdown;
use Daguilarm\Belich\Components\Helpers\Messages;
use Daguilarm\Belich\Components\Helpers\Metrics;
use Daguilarm\Belich\Components\Helpers\Models;
use Daguilarm\Belich\Components\Helpers\Paths;
use Daguilarm\Belich\Components\Helpers\Resources;
use Daguilarm\Belich\Components\Helpers\Routes;
use Daguilarm\Belich\Components\Helpers\Strings;
use Daguilarm\Belich\Components\Helpers\Time;
use Daguilarm\Belich\Components\Helpers\Utils;
use Daguilarm\Bicons\Icons;

final class Helper
{
    use Blade,
        Currency,
        Icons,
        Files,
        Forms,
        Gravatar,
        Markdown,
        Messages,
        Metrics,
        Models,
        Paths,
        Resources,
        Routes,
        Strings,
        Time,
        Utils;

    /**
     * Generate helper's methods
     */
    public function __call(string $method, array $parameters)
    {
        if (method_exists($this, $method)) {
            $reflection = new \ReflectionMethod($this, $method);
            if ($reflection->isPublic()) {
                return call_user_func_array([$this, $method], $parameters);
            }
        }

        abort(403, sprintf('The method %s() not exists', $method));
    }
}
