<?php

namespace Daguilarm\Belich\Fields\Resolves\Handler\Index\Types;

use Closure;
use Daguilarm\Belich\Contracts\HandleField;
use Daguilarm\Belich\Facades\Helper;

final class Select implements HandleField
{
    /**
     * @var string|null
     */
    private $value;

    /**
     * Init constructor
     *
     * @param object $value
     */
    public function __construct(?string $value)
    {
        $this->value = $value;
    }

    /**
     * Handle the relationship value
     *
     * @param object $field
     * @param Closure $next
     *
     * @return object
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
