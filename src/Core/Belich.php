<?php

declare(strict_types=1);

namespace Daguilarm\Belich\Core;

use Daguilarm\Belich\Components\Blade;
use Daguilarm\Belich\Core\BelichMethods;
use Daguilarm\Belich\Core\Traits\Modelable;
use Daguilarm\Belich\Core\Traits\Resourceable;
use Daguilarm\Belich\Core\Traits\Routeable;
use Daguilarm\Belich\Core\Traits\Systemable;
use Daguilarm\Belich\Fields\Resolves\Handler\Index\Values as ResolveBlade;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class Belich extends BelichMethods
{
    use Modelable,
        Resourceable,
        Routeable,
        Systemable;

    public static array $allowedActions = ['index', 'create', 'edit', 'show'];
    protected object $request;
    protected static string $version = '1.1.2';

    public function __construct()
    {
        $this->request = new Request();
        $this->user = \Illuminate\Support\Facades\Auth::user();

        //Set pagination
        if ($this->request->has('perPage')) {
            $this->perPage = $this->request->perPage;
        }
    }

    /**
     * Get the allowed actions
     */
    public static function allowedActions(): array
    {
        return static::$allowedActions;
    }

    /**
     * Prepare the actions for the view
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
     */
    public function components(Request $request): ?string
    {
        return (new Blade())->render($request);
    }

    /**
     * Get the resource filters() method.
     */
    public static function filters(Request $request): array
    {
        $class = static::resourceClassPath();

        return $class::filters($request) ?? false;
    }

    /**
     * Initialize the html helper (for resolving value) in order to be accesible from Belich
     */
    public function value(object $field, ?object $data = null): ?string
    {
        return app(ResolveBlade::class)->handle($field, $data);
    }

    /**
     * Get the resource $tabs variable.
     */
    public static function tabs(): bool
    {
        $class = static::resourceClassPath();

        return $class::$tabs ?? false;
    }

    /**
     * Get the resource relationship table column for render value
     */
    public static function tableColumn(): ?string
    {
        $class = static::resourceClassPath();

        return $class::$column ?? null;
    }
}
