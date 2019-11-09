<?php

namespace Daguilarm\Belich\Core;

use Daguilarm\Belich\Components\Blade;
use Daguilarm\Belich\Core\BelichBase;
use Daguilarm\Belich\Core\Traits\Modelable;
use Daguilarm\Belich\Core\Traits\Operationable;
use Daguilarm\Belich\Core\Traits\Resourceable;
use Daguilarm\Belich\Core\Traits\Routeable;
use Daguilarm\Belich\Core\Traits\Systemable;
use Daguilarm\Belich\Fields\FieldResolveIndex;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class Belich extends BelichBase
{
    use Modelable,
        Operationable,
        Resourceable,
        Routeable,
        Systemable;

    /**
     * @var array
     */
    public static $allowedActions = [
        'index',
        'create',
        'edit',
        'show',
    ];

    /**
     * @var object
     */
    protected $request;

    /**
     * @var string
     */
    protected static $version = '1.0.2';

    /**
     * Init the constuctor
     */
    public function __construct()
    {
        $this->request = request();
        $this->user = \Illuminate\Support\Facades\Auth::user();

        //Set pagination
        if ($this->request->has('perPage')) {
            $this->perPage = $this->request->perPage;
        }
    }

    /**
     * Get the allowed actions
     *
     * @return array
     */
    public static function allowedActions(): array
    {
        return static::$allowedActions;
    }

    /**
     * Prepare the actions for the view
     *
     * @param object $model
     * @param string $view
     *
     * @return Illuminate\View\View
     */
    public function actions(object $model, string $view): View
    {
        //Set view path
        $actionView = 'belich::actions.' . $view;

        return view()->exists($actionView)
            //Custom action
            ? view($actionView, ['model' => $model])
            //Default action
            : view('belich::actions.default', ['model' => $model]);
    }

    /**
     * Initialize the Cards and the Metrics
     *
     * @return string|null
     */
    public function components(Request $request): ?string
    {
        return (new Blade())->render($request);
    }

    /**
     * Initialize the html helper in order to be accesible from Belich
     *
     * @return \Daguilarm\Fields\FieldResolveIndex
     */
    public function html(): FieldResolveIndex
    {
        return app(FieldResolveIndex::class);
    }
}
