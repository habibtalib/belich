# Campos de formularios 


Los formularios se gestionan desde la carpeta de recursos. Es decir, se pueden encontrar en `\App\Belich\Resources\`

En esta carpeta encontraremos todos los recursos de la aplicación. En el campo recurso, encontraremos el método: `fields. Es aquí donde configuraremos nuestro formulario.

~~~
/**
 * Get the fields displayed by the resource.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return Illuminate\Support\Collection
 */
public function fields(Request $request) {
    return [
        Text::make('Usuarios', 'name')
            ->id('user_id')
            ->defaultValue('Usuario 1')
            ->help('this is a help text')
            ->rules('required'),
        Text::make('Facturación', 'user_name', 'billing')
            ->disabled()
            ->sortable()
            ->hideFromIndex()
            ->help('this is a help text')
            ->rules('required'),
        Select::make('Profesiones', 'professions')
            ->options(\App\Models\Profession::all())
            ->defaultValue(1),
    ]
}
~~~

Este sería un ejemplo de cómo funcionaría nuestra función de campos de formulario. 

Este formulario, se encarga de mostrar las cuatro vistas que ofrece cada recurso: `Index`, `Create`, `Edit` y `Show`. Automáticamente renderizará cada vista a partir de la información de esta función.

Todos los tipos de campos deben de incluir un método llamado `make()`. Este método, soporta dos variables: `label` y `attribute`, es decir, el método quedaría de la siguiente forma `make($label, $attribute)`.

Esta regla para el método `make()`, se cumple para todos los campos no relacionales: `Text`, `Select`, `Hidden`, `Textarea`.., sufiendo cambios en los campos relationales: `BelongTo`,...

El campo `label`, generará la etiqueta `<label>` del formulario, mientras el campo attribute, representa la columna de la base de datos vinculado con el campo de formulario.

>El método `fields` recibe la variable `$request`. Esto es así, en caso de que se necesite utilizar algún dato para hacer alguna operación. Por ejemplo: `$request->user()->isAdmin()`, el cual puede ser utilizado para condiciones.


## Métodos soportados

Empezaremos por ver los métodos genéricos y que comparten todos los tipos de campo, y posteriormente, pasaremos a los métodos específicos de cada tipo de campo.


### Visibilidad de campos

El sistema soporta los siguientes métodos:

- `hideFromIndex`
- `hideFromShow`
- `hideWhenCreating`
- `hideWhenEditing`
- `onlyOnIndex`
- `onlyOnDetail`
- `onlyOnForms`
- `exceptOnForms`
- `visibleOn`
- `hideFrom`

Veamos un ejemplo de uso:

~~~
/**
 * Get the fields displayed by the resource.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return Illuminate\Support\Collection
 */
public function fields(Request $request) {
    return [
        Text::make('Usuarios', 'name')
            ->hideFromIndex(),
        Text::make('Facturas', 'bill')
            ->visibleOn('index', 'edit', 'show'),
    ]
}
~~~

El primer formulario de texto, se verá solo en el `index`, mientras que el se mostrará en el `index`, en `edit`  y en `show`, ocultándose en el resto. 

>Recuerda que las cuatro vista soportadas son: `index`, `edit`, `show` y `create`.


### Validación de campos

Mediante el método `rules()` podemos indicar las reglas de validación de cada campo. Utilizando para ello, las mismas reglas que utiliza Laravel.

Los métodos soportados son:

- `rules`
- `creationRules`
- `updateRules`

A modo de ejemplo:

~~~
/**
 * Get the fields displayed by the resource.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return Illuminate\Support\Collection
 */
public function fields(Request $request) {
    return [
        Text::make('Email', 'email')
            ->rules('required', 'email'),
        Text::make('Edad', 'age')
            ->creationRules('required', 'numeric')
            ->updateRules('numeric'),
    ]
}
~~~

En el primer caso, al utilizar el método `rules` indicamos que esas reglas son tanto para cuando creamos como para cuando editamos.

Mientras que en el segundo caso, estamos definiendo reglas diferentes para cuando creamos y para cuando actulizamos.


### Modificación de atributos del campo

En este apartado, veremos como modificar los diferentes atributos de un campo de formulario. Los métodos soportados son:

- `addClass`
- `data`
- `defaultValue`
- `disabled`
- `displayUsing`
- `dusk`
- `help`
- `id`
- `name`
- `readonly`
- `resolveUsing`
- `sortable`

Veamos un ejemplo completo

~~~
/**
 * Get the fields displayed by the resource.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return Illuminate\Support\Collection
 */
public function fields(Request $request) {
    return [
        Text::make('Email', 'email')
            ->addClass('text-blue', 'font-bold')
            ->data('url', 'http://url.com')
            ->defaultValue('email@email.com')
            ->disable()
            ->dusk('dusk-email')
            ->help('Introduzca su email')
            ->id('email_id')
            ->name('email_name')
            ->readonly()
    ]
}
~~~

Debería mostrar:

~~~
<label>Email</label>
    <input type="text" class="text-blue font-bold" data-url="http://url.com value="email@email.com" disabled="disabled" dusk="dusk-email" id="email_id" name="email_name" readonly/>
<div class="help">Introduzca su email</div>
~~~

Faltaría el campo `sortable`. Este campo indica que en la vista `index`, la columna de la tabla correspondiente a este campo, puede ser ordenada de mayor a menor o a la inversa.

Los campos `sortable`, `readonly`, `disabled`, soportan valores boleanos, es decir, podemos añadir condiciones para que se muestren. Eso si, si el valor no es boleano, dará error. A modo de ejemplo:

~~~
/**
 * Get the fields displayed by the resource.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return Illuminate\Support\Collection
 */
public function fields(Request $request) {
    return [
        Text::make('Email', 'email')
            ->readonly(auth()->user()->isAdmin())
    ]
}
~~~


Disponemos también de un método llamado: `displayUsing()`, el cual nos permitirá formatear el valor de nuestro campo (en las vistas `index` y `detail`), realizando un `callback` y permitiéndonos manipular el valor del campo. Se método se usaría de la siguiente forma:

~~~
/**
 * Get the fields displayed by the resource.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return Illuminate\Support\Collection
 */
public function fields(Request $request) {
    return [
        Text::make('Email', 'email')
            ->displayUsing(function($value) {
                return strtolower($value);
            })
    ]
}
~~~


Devolviendo el resultado en minúsculas, permitiéndonos formatear el resultado del campo. **Es decir, podemos acceder al valor del campo y manipularlo**. Si lo que queremos es acceder al modelo, debemos usar el método: `resolveUsing()`. La sintaxis es idéntica a `displayUsing()`:

~~~
/**
 * Get the fields displayed by the resource.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return Illuminate\Support\Collection
 */
public function fields(Request $request) {
    return [
        Text::make('Email', 'email')
            ->resolveUsing(function($model) {
                return $model->relationship->item;
            })
    ]
}
~~~

>Recuerda que tanto `displayUsing()` como `resolveUsing()`, solo afectan a las vistas: `index` y `detail`. El resto de vistas no se ven afectadas por estos métodos.

### Autorización 

Belich permite añadir autorización a los diferentes campos, a través del método `canSee()`.

La sintaxis será: 

~~~
/**
 * Get the fields displayed by the resource.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return Illuminate\Support\Collection
 */
public function fields(Request $request) {
    return [
        Text::make('Email', 'email')
            ->canSee(function($request) {
                return true;
            })
    ]
}
~~~

A través de la variable `$request`, podremos acceder al usuario: 

~~~
/**
 * Get the fields displayed by the resource.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return Illuminate\Support\Collection
 */
public function fields(Request $request) {
    return [
        Text::make('Email', 'email')
            ->canSee(function($request) {
                return $request->user()->isAdmin();
            })
    ]
}
~~~

Lo cual nos permitirá, mostrar u ocultar el campo en función de roles, permisos, etc...

### Tipos de campo

Los campos soportados por Belich, son:

- `ID`
- `Select`
- `Text`
- `Password`
- `PasswordConfirmation`

Cada campo, puede disponer de métodos exclusivos para cada uno de ellos. A continuación, explicamos estós métodos a la vez que explicamos, de forma individual, cada uno de los tipos de campo.

#### Campo Select

El campo select incluye el método `options`, el cual nos permite añadir valores a la etiqueta `option` del `select`.

~~~
Select::make('Role', 'role')
    ->options([1 => 'Admin', 2 => 'Manager', 3 => 'User'])
    ->defaultValue(1)
~~~

Si necesitamos añadir valores desde la base de datos, podemos user el método `__contructor` del recurso en el que se encuentra el formulario:


~~~
/**
 * List of emails from users
 *
 * @var array
 */
protected $selectNames;

/**
 * Generate constructor for the resource
 *
 * @return void
 */
public function __construct()
{
    //Getting data from storage to populate the field
    $this->selectNames = \App\Models\User::pluck('name', 'name')->toArray();
}

/**
 * Get the fields displayed by the resource.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return Illuminate\Support\Collection
 */
public function fields(Request $request) {
    return [
        Select::make('Role', 'role')
            ->options($this->selectNames]),
    ]
}
~~~


#### Campo Text

Este campo adminite los siguientes métodos especiales:

- `withRelationship`

El campo `withRelationship`, se utiliza para mostrar en las vistas: `index`, `show`, `edit`, información de una tabla relacional.

>Debe utilizarse sólo para mostrar información, nunca para crear o actualizar, para ello, disponemos de campos relacionales

Por ejemplo, si nuestra table tiene información sobre vehículos, y disponemos de otra con información de la ubicación GPS del vehículo, en este caso, no queremos que el usuario pueda modificar la información GPS, ya que se actualiza de forma automática, pero si queremos mostrarla. Es en estos casos, cuando puede utilizarse un campo `Text` con relaciones.

~~~
/**
 * Get the fields displayed by the resource.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return Illuminate\Support\Collection
 */
public function fields(Request $request) {
    return [
        Text::make('GPS', 'gps_location')
            ->withRelationship('location'),
    ]
}
~~~

El ejemplo anterior, buscará la información `$field->location->gps_location`. 

Este campo se mostrará en las vistas: `index` y `show`, se le añadirá el attributo `disabled` en la vista `edit` y se eliminará de la vista: `create`.

Para evitar problemas n+1, debemos añadir la relación al modelo. Para ello, al definir el modelo de nuestro recurso, debemos hacer lo siguiente:

~~~
/** @var string [Model path] */
public static $model = '\App\Models\Car';

/** @var array */
public static $relationships = ['location'];
~~~
