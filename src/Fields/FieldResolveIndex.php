<?php

namespace Daguilarm\Belich\Fields;

use Daguilarm\Belich\Facades\Belich;
use Daguilarm\Belich\Fields\ResolveIndex\Resolve;
use Daguilarm\Belich\Fields\ResolveIndex\Table;
use Daguilarm\Belich\Fields\Traits\Constructable\Callbackable;
use Daguilarm\Belich\Fields\Traits\Constructable\Fileable;
use Illuminate\Support\Collection;

final class FieldResolveIndex
{
    use Callbackable, Fileable;

    /**
     * Resolve fields: auth, visibility, value,...
     *
     * @param object $fields
     *
     * @return Illuminate\Support\Collection
     */
    public function make(object $fields): Collection
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

        return collect([
            'data' => $fields,
            'labels' => app(Table::class)->headerLabels($fields),
        ]);
    }

    /**
     * Resolve field values for: relationship, displayUsing and resolveUsing
     * This method is used throw Belich Facade => Belich::html()->resolveField($field, $data);
     * This method is for refactoring the blade templates.
     *
     * @param  Daguilarm\Belich\Fields\Field $attribute
     * @param  object $data
     *
     * @return string|null
     */
    public function resolve(Field $field, ?object $data = null): ?string
    {
        //Resolve value for action controller: show
        $value = $field->value;

        //Handle the resolve class
        $resolve = new Resolve();

        //Resolve value
        $value = $resolve->resolveValue($field, $data, $value);

        // If boolean
        // Please respect this orden -> first $this->resolveValue($field, $data, $value)
        // then $this->resolveBoolean($field, $value)
        if ($field->type === 'boolean') {
            return $resolve->resolveBoolean($field, $value);
        }

        //File field
        if ($field->type === 'file') {
            return $this->resolveFile($field, $value);
        }

        //File field
        if ($field->displayUsingLabels) {
            return $resolve->displayUsingLabels($field, $value);
        }

        //Resolve the field value through callbacks
        return $this->getCallbackValue($field, $data, $value);
    }

    /**
     * Resolve if the row is softdeleted
     * This method is used throw Belich Facade => Belich::html()->resolveSoftdeleting($field, $data);
     * This method is for refactoring the blade templates.
     * It is use for @hasSofdeleting
     *
     * @param  Daguilarm\Belich\Fields\Field $attribute
     * @param  object $data
     *
     * @return bool
     */
    public function resolveSoftdeleting(Field $field, ?object $data = null): bool
    {
        return method_exists(Belich::getModel(), 'trashed') && $data->trashed();
    }
}
