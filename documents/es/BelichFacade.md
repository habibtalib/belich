# Belich Facade


Belich, dispone de una Facade que puede ser utilizada de forma directa (sin necesidad de configurar nada), desde cualquier parte del proyecto.

Podemos utilizarla en nuestro template:

~~~
{{ Belich::name() }}
~~~

Los métodos soportados son:

#### action()

Nos devolverá el último valor de la función `route`, es decir, la acción que se está producciendo en el Controlador del package. Devolverá cuatro estados por defecto:

`index`, `edit`, `create` y `show`.

#### actionRoute()

Nos genera un enlace directo para una acción, a partir de cualquiera de las cuatro acciones soportadas y identificador del recurso. El formato sería el siguiente:

~~~
Belich::actionRoute($controllerAction, $data)
~~~

A modo de ejemplo:

~~~
Belich::actionRoute('index')
~~~

Nos devolvería un enlace al index del recurso actual. El segundo parámetro `$data`, podemos pasarlo de dos formas:

- Como objeto, obteniendo el ID a partir de él.
- Como número entero, utilizando el ID directamente.

Por ejemplo:

~~~
Belich::actionRoute('edit', $model)
Belich::actionRoute('edit', 201)
~~~

#### count()

Nos permite obtener el número total de resultados de un objeto o array. El formato utilizado sería:

~~~
Belich::count($value, int $initialValue = 0)
~~~

La variable `$value`, sería el array u objeto a contar, permitiendo un segundo parámetro, que nos permite inicial la cuenta en el valor que necesitemos. Por defecto, será 0. Por ejemplo:

~~~
Belich::count(\App\Models\User::all())
Belich::count([1, 2, 3, 4, 5])
~~~

#### currentResource()

Nos devuelve la información del recurso actual, mediante una colección. Los datos que ofrece son:

- **name**: El nombre de la clase pluralizado y minúscula, mediante `routeResource()`.
- **controllerAction**: Nos muestra la acción que se está producciendo en el Contr*olador, mediante el método `routeAction()`.
- **fields**: Colección con todos los valores del formulario actualizados.
- **results**: Colección con todos los resultados de la base de datos para el recurso. Si nos encontramos en el `index`, nos devolverá un listado de recurso, si nos encontramos en `show` o `edit` nos devolverá el valor para ese recurso en base a su ID, y si nos encontramos en `create`, será una instancia vacia del modelo.
- **breadcrumbs**: Nos devuelve un array con los valores del breadcrumb, que pueden ser personalizados desde el recurso. 

El formato del array será:

~~~
[
    'title1' => 'http://www.domain.com',
    'title2' => 'http://www.domain.com',
    'title3' => 'http://www.domain.com',
    'Current resource label',
]
~~~

#### name()

Obtenemos el nombre de la aplicación del archivo de configuración: `.\config\belich.php`.

#### middleware() 

Nos devuelve un `array` con todos los middlewares configurados en `config\belich.php`

#### path() 

Es el path de la aplicación. Se obtiene del archivo de configuración: `.\config\belich.php`.

#### pathName()

Si al ejecutar el método anterior `path()`, obtenemos la carpeta (por ejemplo) `dashboard/`, al llamar al método `pathName`, obtendremos `dashboard` sin la barra.

#### resourceUrl()

Nos da la url completa del recurso actual: `http://url.com/dashboard/resource`

#### route()

Las rutas del package se generan automáticamente con el siguiente formato: `dashboard.resource.action`. Ahora imaginemos que nuestra ruta actual es `dashboard.users.index`. El método `route()` nos devolverá un array con los tres valores de la ruta:

~~~
[
    'dashboard',
    'users',
    'index'
] 
~~~

#### resource()

Este método nos devuelve el segundo térmido de la ruta. El que pertenece al recurso actual.

#### resourceClassPath($className = null)

Lo mismo que `resourceClassName()` pero con el path completo de la clase. Usando el ejemplo anterior: `\App\Belich\Resources\User`.

El método, nos devuelve la clase actual, si dejamos en blanco la variable `$className`. Podemos añadir un nombre de clase personalizado, y nos devolverá la ruta completa de la clase.

>El recurso es mostrado en plural y en minúscula. Usando el ejemplo anterior: users.

#### resourceId()

En las acciones `edit` y `show`, nos mostrará el ID del recurso actual.

#### resourceName()

Nos devuelve el nombre de la clase del recurso actual, por ejemplo: `User`.

#### resourceUrl()

Nos devuelve la url completa al recurso (index).

#### resourcesAll()

Nos devuelve el listado completo de recursos que se encuentra en el directorio: `\App\Belich\Resources\`, devolviendo una colección con los siguientes valores por cada recurso:

- **class**: Nombre de la clase, a través de `resourceClassName()`.
- **resource**: El nombre de la clase pluralizado y minúscula, mediante `routeResource()`.
- **displayInNavigation**: Nos indica si el recurso debe mostrarse en la barra de navegación seleccionada.
- **group**: El grupo donde guardar el recurso, y posteriormente, mostrarlo en la barra de navegación seleccionada.
- **label**: La etiqueta en singular que hemos asignado al recurso.
- **pluralLabel**: La etiqueta en plural que hemos asignado al recurso.

#### url() 

Es la url base de la aplicación. Se obtiene del archivo de configuración: `.\config\belich.php`.

#### version() 

Nos devuelve la versión action del package.

## Métodos para Blade 

También podemos generar helpers especializados para nuestras plantillas Blade. A veces necesitamos generar código HTML en Blade, y no queremos añadir código PHP a nuestro template. Para ello, se han desarrollado algunos helpers para ser utilizados de forma directa.

Normalmente, estos métodos son utilizados por el sistema, pero pueden ser útiles para desarrollar módulos propios, nuevos campos de formulario o packages.

La sintaxis para utilizar estos helpers será:

~~~
Belich::blade()->method()
~~~

>Si olvidamos añadir el método `blade()`, dará error.

Los métodos soportados son:

#### renderOrderedLink()

Igual que la anterior, pero añade dos nuevos parámetros:

- **order**: que será el campo de la base de datos por el que queremos ordenar la lista.
- **direction**: aceptando los parámetros `ASC` y `DESC`.

Quedando algo así:

`http://www.url.com/?perPage=20&page=2&relationship=billings&order=users&direction=DESC`

~~~
Belich::blade()->renderOrderedLink()
~~~

Es utilizado por el sistema en la vista `index`.
