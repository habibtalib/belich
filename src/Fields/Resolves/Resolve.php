<?php

namespace Daguilarm\Belich\Fields\Resolves;

use Daguilarm\Belich\Facades\Belich;
use Daguilarm\Belich\Fields\Resolves\Authorization;
use Daguilarm\Belich\Fields\Resolves\Callback;
use Daguilarm\Belich\Fields\Resolves\File;
use Daguilarm\Belich\Fields\Resolves\Render;
use Daguilarm\Belich\Fields\Resolves\ResolveIndex;
use Daguilarm\Belich\Fields\Resolves\Value;
use Daguilarm\Belich\Fields\Resolves\Visible;
use Illuminate\Support\Collection;

final class Resolve
{
    /**
     * @var string
     */
    private $action;

    /**
     * @var Daguilarm\Belich\Fields\Resolve\Autorization
     */
    private $auth;

    /**
     * @var object
     */
    private $fields;

    /**
     * @var Daguilarm\Belich\Fields\Resolve\Render
     */
    private $noResolveActions = ['destroy', 'store', 'update'];

    /**
     * @var Daguilarm\Belich\Fields\Resolve\Render
     */
    private $render;

    /**
     * @var object
     */
    private $sql;

    /**
     * @var Daguilarm\Belich\Fields\Resolve\Value
     */
    private $value;

    /**
     * @var Daguilarm\Belich\Fields\Resolve\Visible
     */
    private $visible;

    /**
     * Init constructor
     */
    public function __construct(Authorization $auth, Render $render, Value $value, Visible $visible)
    {
        $this->action = Belich::action();
        $this->auth = $auth;
        $this->render = $render;
        $this->value = $value;
        $this->visible = $visible;
    }

    /**
     * Resolve fields: auth, visibility, value,...
     *
     * @param object $fields
     * @param object $fields
     *
     * @return Illuminate\Support\Collection
     */
    public function execute(object $fields, object $sql): Collection
    {
        //Filter
        //Prepare the fields for resolving...
        $fields = $fields->flatten();

        //Policies
        //Authorization for 'show', 'edit' and 'update' actions
        //This go here because we want to avoid duplicated sql queries...Don't remove!!!
        $this->auth->policy($sql, $this->action);

        //Authorization for fields
        $fields = $this->auth->fields($fields);

        //Controller actions
        //Resolve fields base on the controller action
        //No resolve field for not visual actions
        if (in_array($this->action, $this->noResolveActions)) {
            return new Collection();
        }

        // Check for action value
        return $this->action === 'index'
            //Prepare the field for the index response
            ? (new ResolveIndex($this->action, new Callback(), new File(), $this->visible))
                ->controller($fields)
            //Prepare the field for the the form response: create, edit and show
            : (new ResolveCrud($this->action, $this->render, $this->value, $this->visible))
                ->controller($fields, $sql);
    }
}
