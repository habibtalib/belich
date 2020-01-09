<?php

namespace Daguilarm\Belich\Fields\Types\Relationships;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class BelongsToMany extends BelongsTo
{
    /**
     * @var string
     */
    public $subType = 'belongsToMany';

    /**
     * Create a new relationship field
     *
     * @param  string  $label
     * @param  string  $resource [The relational resource in plural]
     * @param  string|null  $relationship [The relational model]
     * @param  string|null  $tableColumn [The relational table from the model]
     *
     * @return  void
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
