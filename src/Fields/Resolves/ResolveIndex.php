<?php

namespace Daguilarm\Belich\Fields\Resolves;

use Daguilarm\Belich\Fields\Resolves\Table;
use Illuminate\Support\Collection;

final class ResolveIndex
{
    /**
     * @var string
     */
    private $action;

    /**
     * @var Daguilarm\Belich\Fields\Resolve\Callback
     */
    private $callback;

    /**
     * @var Daguilarm\Belich\Fields\Resolve\File
     */
    private $file;

    /**
     * @var Daguilarm\Belich\Fields\Resolve\Visible
     */
    private $visible;

    /**
     * Get controller action
     */
    public function __construct(string $action, Callback $callback, File $file, Visible $visible)
    {
        $this->action = $action;
        $this->callback = $callback;
        $this->file = $file;
        $this->visible = $visible;
    }

    /**
     * Resolve fields: auth, visibility, value,...
     *
     * @param object $fields
     *
     * @return Illuminate\Support\Collection
     */
    public function controller(object $fields): Collection
    {
        $fields = $fields->map(static function ($field) {
            //Showing field relationship in index
            //See blade template: dashboard.index
            $field->attribute = $field->fieldRelationship
                //Prepare field for relationship
                ? [$field->fieldRelationship, $field->attribute]
                //No relationship field
                : $field->attribute;

            return $field;
        });

        // Resolve visibility for fields
        $fields = $this->visible->execute($this->action, $fields);

        return collect([
            'data' => $fields,
            'labels' => app(Table::class)->header($fields),
        ]);
    }
}
