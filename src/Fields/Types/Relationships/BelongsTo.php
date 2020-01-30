<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Types\Relationships;

use Daguilarm\Belich\Fields\Types\Relationships\HasOne;

final class BelongsTo extends HasOne
{
    public string $subType = 'belongsTo';

    /**
     * Create a new relationship field
     */
    public function __construct(string $label, string $resource, ?string $tableColumn = null)
    {
        parent::__construct($label, $resource, $tableColumn);

        // Resolve as html
        $this->asHtml();

        // Show in all
        $this->showInAll();
    }
}
