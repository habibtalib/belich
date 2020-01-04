<?php

namespace Daguilarm\Belich\Fields\Resolves\Handler\Index\Types;

use Closure;
use Daguilarm\Belich\Contracts\HandleField;

final class File implements HandleField
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
     * Resolve file value
     *
     * @param object $field
     * @param Closure $next
     *
     * @return object
     */
    public function handle(object $field, Closure $next): object
    {
        //File field
        if ($field->type === 'file') {
            $field->value = app(File::class)->handle($field, $this->value);
        }

        return $next($field);
    }
}
