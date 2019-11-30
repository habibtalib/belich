<?php

namespace Daguilarm\Belich\Fields\Resolves;

use Daguilarm\Belich\Fields\Resolves\Callback;
use Daguilarm\Belich\Fields\Resolves\File;
use Daguilarm\Belich\Fields\Resolves\Visible;
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
        $fields = $fields->map(function ($field) {
            // Resolve field relationship
            $field = $this->resolveRelationship($field);

            // Resolve field color
            $field = $this->resolveColor($field);

            return $field;
        });

        // Resolve visibility for fields
        $fields = $this->visible->execute($this->action, $fields);

        return collect([
            'data' => $fields,
        ]);
    }

    /**
     * Resolve field color
     *
     * @param object $fields
     *
     * @return object
     */
    private function resolveColor(object $field): object
    {
        // Resolve color
        if ($field->type === 'color' && isset($field->asColor) && $field->asColor === true) {
            // Set value
            $field->asHtml();
        }

        return $field;
    }

    /**
     * Resolve field relationship
     *
     * @param object $fields
     *
     * @return object
     */
    private function resolveRelationship(object $field): object
    {
        //Showing field relationship in index
        //See blade template: dashboard.index
        $field->attribute = $field->fieldRelationship
            //Prepare field for relationship
            ? [$field->fieldRelationship, $field->attribute]
            //No relationship field
            : $field->attribute;

        return $field;
    }
}
