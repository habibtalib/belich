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

- `data`
- `defaultValue`
- `disabled`
- `dusk`
- `help`
- `id`
- `name`
- `readonly`
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
    <input type="text" data-url="http://url.com value="email@email.com" disabled="disabled" dusk="dusk-email" id="email_id" name="email_name" readonly/>
<div class="help">Introduzca su email</div>
~~~

Faltaría el campo `sortable`. Este campo indica que en la vista `index`, la columna de la tabla correspondiente a este campo, puede ser ordenada de mayor a menor o a la inversa.
