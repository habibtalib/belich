# Belich Facade


Belich, dispone de una Facade que puede ser utilizada de forma directa (sin necesidad de configurar nada), desde cualquier parte del proyecto.

Podemos utilizarla en nuestro template:

~~~
{{ Belich::name() }}
~~~

Los métodos soportados son:

#### version() 

Nos devuelve la versión action del package.


#### name()

Obtenemos el nombre de la aplicación del archivo de configuración: `.\config\belich.php`.


#### path() 

Es el path de la aplicación. Se obtiene del archivo de configuración: `.\config\belich.php`.


#### url() 

Es la url base de la aplicación. Se obtiene del archivo de configuración: `.\config\belich.php`.


#### route()

Las rutas del package se generan automáticamente con el siguiente formato: `dashboard.resource.action`. Ahora imaginemos que nuestra ruta actual es `dashboard.users.index`. El método `route()` nos devolverá un array con los tres valores de la ruta:

~~~
[
    'dashboard',
    'users',
    'index'
] 
~~~


#### routeAction()

Nos devolverá el último valor de la función `route`, es decir, la acción que se está producciendo en el Controlador del package. Devolverá cuatro estados por defecto:

`index`, `edit`, `create` y `show`.


#### routeResource()

Este método nos devuelve el segundo térmido de la ruta. El que pertenece al recurso actual.

>El recurso es mostrado en singular y en minúscula.


#### routeId()

En las acciones `edit` y `show`, nos mostrará el ID del recurso actual.


#### currentLabel($class) 

Devolverá la etiqueta del recurso en función de la acción del controlador. El valor devuelto ser el `$label` o `$pluralLabel`, a continuación se determinan los valores para cada acción del controlador.

- index: `$pluralLabel`
- edit: `$label`
- create: `$label`
- show: `$label`


#### resourceClassName()

Nos devuelve el nombre de la clase del recurso actual, por ejemplo: `User`.


#### resourceClass($className = null)

Lo mismo que `resourceClassName()` pero con el path completo de la clase. Usando el ejemplo anterior: `\App\Belich\Resources\User`.

El método, nos devuelve la clase actual, si dejamos en blanco la variable `$className`. Podemos añadir un nombre de clase personalizado, y nos devolverá la ruta completa de la clase.


#### resourcesAll()

Nos devuelve el listado completo de recursos que se encuentra en el directorio: `\App\Belich\Resources\`, devolviendo una colección con los siguientes valores por cada recurso:

- **class**: Nombre de la clase, a través de `resourceClassName()`.
- **resource**: El nombre de la clase pluralizado y minúscula, mediante `routeResource()`.
- **displayInNavigation**: Nos indica si el recurso debe mostrarse en la barra de navegación seleccionada.
- **group**: El grupo donde guardar el recurso, y posteriormente, mostrarlo en la barra de navegación seleccionada.
- **label**: La etiqueta en singular que hemos asignado al recurso.
- **pluralLabel**: La etiqueta en plural que hemos asignado al recurso.


#### resource()

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
