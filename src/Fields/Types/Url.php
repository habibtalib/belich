<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Fields\Types\Text;

final class Url extends Text
{
    public string $type = 'url';
}
