<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Types;

use Daguilarm\Belich\Core\Belich;
use Daguilarm\Belich\Fields\Field;
use Daguilarm\Belich\Fields\Traits\Disabled\NoResolvable;

final class ID extends Field
{
    use NoResolvable;

    public string $type = 'text';

    public function __construct($name = null, $attribute = 'id')
    {
        parent::__construct($name ?? 'ID', $attribute ?? Belich::getModelKeyName());

        //Set visibility
        $this->forceVisibility('index', 'show');

        //Not resolve or display field
        $this->notResolveField();
    }
}
