<?php

namespace Daguilarm\Belich\Fields\Resolves;

use Daguilarm\Belich\Facades\Belich;
use Daguilarm\Belich\Fields\Resolves\Handler\Crud\Resolve as ResolveCrud;
use Daguilarm\Belich\Fields\Resolves\Handler\Index\Resolve as ResolveIndex;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Collection;

final class Resolve
{
    /**
     * @var string
     */
    private $action;

    /**
     * @var object
     */
    private $fields;

    /**
     * @var Daguilarm\Belich\Fields\Resolve\Render
     */
    private $noResolveActions = ['destroy', 'store', 'update'];

    /**
     * Init constructor
     */
    public function __construct()
    {
        $this->action = Belich::action();
    }

    /**
     * Resolve fields: auth, visibility, value,...
     *
     * @param object $fields
     * @param object $sql
     *
     * @return Illuminate\Support\Collection
     */
    public function handle(object $fields, object $sql): Collection
    {
        // Resolve fields
        $fields = $this->resolveFieldsThroughPipeline($fields, $sql);

        // Resolve action
        return $this->action === 'index'
            //Prepare the field for the index response
            ? $this->resolveIndex($fields)
            //Prepare the field for the the form response: create, edit and show
            : $this->resolveCrud($fields, $sql);
    }

    /**
     * Resolve fields
     *
     * @param object $fields
     * @param object $sql
     *
     * @return Illuminate\Support\Collection
     */
    private function resolveFieldsThroughPipeline(object $fields, object $sql): Collection
    {
        return app(Pipeline::class)
            ->send($fields)
            ->through($this->pipeline($sql))
            ->thenReturn();
    }

    /**
     * Pipeline array
     *
     * @param object $sql
     *
     * @return array
     */
    private function pipeline($sql): array
    {
        return [
            //Prepare the fields for resolving...
            \Daguilarm\Belich\Fields\Resolves\Handler\FieldsPrepare::class,
            //Authorize policies for 'show', 'edit' and 'update' actions
            //This go here because we want to avoid duplicated sql queries...Don't remove!!!
            new \Daguilarm\Belich\Fields\Resolves\Handler\AuthorizePolicies($sql, $this->action),
            //Authorization for fields
            \Daguilarm\Belich\Fields\Resolves\Handler\AuthorizeFields::class,
            //Not resolve fields for not visual actions, like: internal operations, ajax,...
            new \Daguilarm\Belich\Fields\Resolves\Handler\NotVisualActions($this->noResolveActions, $this->action),
        ];
    }

    /**
     * Resolve index
     *
     * @param object $fields
     *
     * @return Illuminate\Support\Collection
     */
    private function resolveIndex($fields)
    {
        return app(ResolveIndex::class)->handle($fields);
    }

    /**
     * Resolve crud
     *
     * @param object $fields
     * @param object $sql
     *
     * @return Illuminate\Support\Collection
     */
    private function resolveCrud($fields, $sql)
    {
        return app(ResolveCrud::class)->handle($fields, $this->action, $sql);
    }
}
