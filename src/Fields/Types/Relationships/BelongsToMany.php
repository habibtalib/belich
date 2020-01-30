<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Fields\Types\Relationships;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class BelongsToMany extends BelongsTo
{
    public string $subType = 'belongsToMany';

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
