<?php

namespace Daguilarm\Belich\Fields\Resolves\Handler\Index\Types;

use Closure;
use Daguilarm\Belich\Contracts\HandleField;
use Daguilarm\Belich\Fields\Resolves\Handler\Index\File as ImportFile;

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
            $field->value = app(ImportFile::class)->handle($field, $this->value);
        }

        return $next($field);
    }
}
