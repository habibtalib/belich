# Recursos

Belich dispone de un comando para `artisan`, para crear facilmente recursos:

~~~
php artisan belich:policy PolicyName
~~~

Puede encontrar más información en: [Comandos de consola](Commands.md), donde se especifican todas las opciones disponibles.

Una vez que el recurso está creado, disponemos de una serie de variables a configurar:

## Variables disponibles

A continuación se detallan todos las variables de configuración disponibles para un recurso.

#### accessToResource

Esta variable, nos va a permitir deshabilitar el acceso a un recurso, y evitar por tanto, que esté disponible para navegación, aunque podremos utilizarlo para generar relaciones con otros recursos.

~~~
/** @var bool */
public static $accessToResource = false;
~~~

Esta variable está activada por defecto, por lo que no es necesario añadirla.

#### actions

Belich dispone de una serie de archivos `blade`, que están ubicados en la carpeta: `\resources\views\actions\`. En estos archivos se encuentran los botones de accion, que aparecerán en le `index` de los recursos:

~~~
@can('view', $model)
    <a href="{{ Belich::actionRoute('show', $model) }}" class="action">@actionIcon('eye')</a>
@endcan

@can('update', $model)
    <a href="{{ Belich::actionRoute('edit', $model) }}" class="action">@actionIcon('edit')</a>
@endcan

@can('delete', $model)
    <a href="{{ Belich::actionRoute('destroy', $model) }}" class="action">@actionIcon('trash')</a>
@endcan
~~~

Por defecto, Belich accede al archivo `default.blade.php`, pero podemos crear (en dicha carpeta), nuestro propio archivo personalizado para ser utilizado en nuestro recurso, de forma, que podemos crear diferentes archivos para cada recurso.

Ahora, solo tenemos que indicarle a Belich que archivo utilizar en cada recurso:

~~~
/** @var string */
public static $actions = 'newAction';
~~~

>Solo utilizar esta variable, si deseamos cambiar el archivo por defecto.

#### displayInNavigation

Sirve para indicar si queremos que el recurso aparezca en los menus: tanto el superior como el lateral.

~~~
/** @var bool */
public static $displayInNavigation = true;
~~~

Esta variable está activada por defecto, por lo que no es necesario añadirla.

#### downloable

Sirve para indicar si el recurso puede ser exportado a los diferentes formatos disponibles.

~~~
/** @var bool */
public static $downloable = true;
~~~

Esta variable está activada por defecto, por lo que no es necesario añadirla.


#### group

Sirve para indicar que nuestro recurso, debe agruparse en un grupo determinado, creando un menu y su respectivo submenu en la navegación.

~~~
/** @var string */
public static $group = 'My Group Name';
~~~

Si lo dejamos en blanco, se considerará el recurso como raiz, y no se le asignarán subniveles, quedando como a continuación (Resource 3):

~~~
\Group1
    \Resource 1 
    \Resource 2
\Resource 3
~~~

#### hideMetricsForScreens

Podemos indicarle a Belich, que no queremos mostrar gráficas en dispositivos pequeños, para ello, haremos lo siguiente:

~~~
/** @var array */
public static $hideMetricsForScreens = ['sm'];
~~~

Los valores soportados son:

- **sm**: a partir de 576px.
- **md**: a partir de 768px.
- **lg**: a partir de 992px.
- **xl**: a partir de 1200px.

Este valor esta desactivado por defecto, por lo que las gráficas estarán disponibles por defecto.

>Esta misma opción, también esta disponible de forma global en el archivo de configuración. En caso de que ambos estén activos, prevalecerá el valor del recurso.

#### Asociar recurso con icono

Podemos asociar nuestro recurso con un icono de [Font-Awesome](https://origin.fontawesome.com). Para ello, debemos hacer lo siguiente:

~~~
/** @var string */
public static $icon = 'user-friends';
~~~

Simplemente debemos indicar el nombre que usa `fontawesome` para el icono.

>Este valor esta desactivado por defecto, por lo que debemos indicarle el nombre del icono si queremos que se muestre.

$redirectTo = 'index, create, detail, edit';

#### Nombre del recurso 

Para identificar el recurso, utilizamos etiquetas. Estas etiquetas son utilizadas por Belich, para referirse a el recurso en: menus, breadcrumbs, etc. 

Existen dos tipos de etiquetas para identificar el recurso, la singular y la plural:

~~~
/** @var string */
public static $label = 'User';

/** @var string */
public static $pluralLabel = 'Users';
~~~

>Si las dejamos en blanco, el sistema identificará el recurso con el nombre del archivo, y su versión en plural.

#### Identificación del modelo

Debemos indicarle a Belich qué modelo utilizar y donde está ubicado:

~~~
/** @var string [Model path] */
public static $model = '\App\User';
~~~

>Este campo es obligatorio

#### Redirecciones 

Después de realizar una acción, por ejemplo, crear un recurso. Podemos indicarle a Belich hacia donde queremos que redireccione.

~~~
/** @var string */
public static $redirectTo = 'index';
~~~

Hay que indicarle la acción que queremos que resuelva. Las acciones disponibles son:

- **index**
- **show**
- **create** 
- **update**

>Por defecto, Belich direccionará al index.

#### Relaciones 

Para evitar problemas de N+1 en las consultas a la base de datos, y utilizar `eager loading`, debemos indicarle a Belich que relaciones debe añadir a la consulta a la base de datos que realizará el modelo.

~~~
/** @var array */
public static $relationships = ['billing'];
~~~


#### softDeletes

Debemos indicarle a Belich, si nuestro modelo incluye `softdeletes`. Si es así, demos indicárselo de la siguiente forma:

~~~
/** @var array */
public static $softDeletes = true;
~~~

>Por defecto está desactivado.

## Métodos obligatorios

Disponemos de una serie de métodos que deben incluirse de forma obligatoria en cada recurso:

#### fields

Este método, nos permitirá generar los diferentes campos de cada recurso:

~~~
/**
 * Get the fields displayed by the resource.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return Illuminate\Support\Collection
 */
public function fields(Request $request) {
    return [
        ID::make('Id'),
        Text::make('Name', 'name')
            ->sortable()
            ->rules('required'),
        Text::make('Email', 'email')
            ->rules('required', 'email', 'unique:users,email')
            ->sortable(),
        Password::make('Password', 'password')
            ->creationRules('required', 'required_with:password_confirmation', 'confirmed', 'min:6')
            ->updateRules('nullable', 'required_with:password_confirmation', 'same:password_confirmation', 'min:6')
            ->onlyOnForms(),
        PasswordConfirmation::make('Password confirmation'),
    ];
}
~~~

Puede encontrar más información en: [Campos de formulario](Fields.md), donde se especifican todas las opciones disponibles.

#### cards 

Sirve par indicarle al recurso que componentes (card) debe de incluir:

~~~
/**
 * Set the custom cards
 *
 * @param  \Illuminate\Http\Request  $request
 * @return Illuminate\Support\Collection
 */
public static function cards(Request $request) {
    new \App\Belich\Cards\UserCard($request),
}
~~~

Puede encontrar más información en: [Cards](Cards.md), donde se especifican todas las opciones disponibles.

#### metrics 

Sirve par indicarle al recurso que métricas debe de incluir:

~~~
/**
 * Set the custom metrics cards
 *
 * @param  \Illuminate\Http\Request  $request
 * @return Illuminate\Support\Collection
 */
public static function metrics(Request $request) {
    return [
        new \App\Belich\Metrics\UsersPerMonth($request),
        new \App\Belich\Metrics\UsersPerDay($request),
        new \App\Belich\Metrics\UsersPerHour($request),
    ];
}
~~~

Puede encontrar más información en: [Gráficas y estadísticas](Metrics.md), donde se especifican todas las opciones disponibles.
