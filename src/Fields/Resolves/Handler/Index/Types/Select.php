<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Resolves\Handler\Index\Types;

use Closure;
use Daguilarm\Belich\Contracts\HandleField;
use Daguilarm\Belich\Facades\Helper;

final class Select implements HandleField
{
    private ?string $value;

    public function __construct(?string $value)
    {
        $this->value = $value;
    }

    /**
     * Handle the relationship value
     */
    public function handle(object $field, Closure $next): object
    {
        //Resolve using Display Using Labels
        if (isset($field->displayUsingLabels) && isset($field->options)) {
            $field->value = Helper::displayUsingLabels($field, $this->value);
        }

        return $next($field);
    }
}
