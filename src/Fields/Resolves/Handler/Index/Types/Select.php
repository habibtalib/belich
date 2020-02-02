<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Resolves\Handler\Index\Types;

use Closure;
use Daguilarm\Belich\Contracts\HandleField;
use Daguilarm\Belich\Facades\Helper;

final class Select implements HandleField
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Handle the relationship value
     */
    public function handle(object $field, Closure $next): object
    {
        //Resolve using Display Using Labels
        if ($this->condition($field)) {
            $field->value = Helper::displayUsingLabels($field, $this->value);
        }

        return $next($field);
    }

    /**
     * Check for condition
     */
    private function condition(object $field)
    {
        return isset($field->displayUsingLabels) && $field->displayUsingLabels && isset($field->options) && $field->options;
    }
}
