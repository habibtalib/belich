<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Resolves\Handler\Index\Types;

use Closure;
use Daguilarm\Belich\Contracts\HandleField;
use Daguilarm\Belich\Fields\Resolves\Handler\Index\File as ImportFile;

final class File implements HandleField
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Resolve file value
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
