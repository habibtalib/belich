# Archivo de configuración

El archivo de configuración, se genera en la carpeta de configuración de Laravel: `\config\belich.php`.

En este archivo, vamos a poder configurar Belich de forma sencillar y rápida. Dispone de diferentes apartados, que vamos a ir viendo uno a uno.

## Configuración de la aplicación

- **name**: El nombre de la aplicación. Por defecto:`Belich Dashboard`.
- **path**: La ruta desde la que se accederá a Belich. Por defector: `dashboard/.
- **url**: Url donde está ubicado Belich. Por defecto:`/`.

## Navegación

Belich, ofrece dos formas de navegación, mediante barra superior o lateral.

- **navbar**: admite dos opciones `top` o `sidebar`.

La opción por defecto, es `top`. En ella se prescinde de la barra lateral, y los recursos son mostrados en la barra superior. Es una opción indicada cuando vamos a mostrar grandes tablas con muchos datos.

La opción `sidebar`, nos ofrece los recursos en la barra lateral, y deja la bara superior para mostrar la configuración de usuario y el fin de sesión.

## Middleware

Podemos configurar el middleware según nuestras necesidades. Por defecto, se utilizan:

- **https**: middleware para garantizar que siempre se utiliza una url segura. Esta opción, es optativa y puede eliminarse sin mayor problema.
- **web**: carga una buena parte del middleware que ofrece por defecto Laravel. Eliminar solo si se sabe que se está haciendo.
- **auth**: autentificación por defecto de Laravel. Eliminar solo si se sabe que se está haciendo.

Para añadir middleware personalizado, solo tenemos que añadirlo al array:

~~~
'middleware' => [
    'https',
    'web',
    'auth',
    'customMiddelware1',
    'customMiddelware2',
    ...
],
~~~

## Exportar archivo

Selección del driver de exportación de bases de datos a archivos. Desde aquí, podrá configurar que driver utilizará Belich para generar archivos `XLS`, `XLSX` o `CSV`, a partir de la base de datos.

Seleccione el driver que prefiera, a partir de la lista suministrada:

~~~
'export' => [
    'driver' => 'fast-excel',
],
~~~


## Parámetros permitidos en la URL 

Belich, limita los parámetros que pueden ser enviados por la URL, y por tanto, ser utilizados por la aplicación. Si añadimos parámetros a la URL, Belich automáticamente los eliminará, por lo tanto, si queremos añadir parámetros nuevos, tendremos que hacerlo a traves del campo `allowedUrlParameters`.

Por defecto, tiene este aspecto:

~~~
'allowedUrlParameters' => []
~~~

Es decir, sólo utiliza los parámetros por defecto de Belich. Si queremos añadir nuestros propios parámetros, tendremos que hacerlo de la siguiente forma:

~~~
'allowedUrlParameters' => ['param1', 'param2',...]
~~~

## Minimizar el HTML de la aplicación

Belich utiliza un `middleware` para comprimir el código HTML de la aplicación, antes de ser cacheado por Laravel. Este proceso, aporta una disminución del tamaño del web. Esta disminución de tamaño, suelo estar en torno al 25%, aunque es variable, y dependerá de las características de cada proyecto.

Por defecto, esta opción se encuentra activada, pero puede desactivarse de forma sencilla:

~~~
'minifyHtml' => [
    'enable' => false,
]
~~~

Puede suceder que este `middleware` afecte a otras partes del proyecto, propiciando que no funcione correctamente. 

Por ejemplo, para evitar problemas con la exportación de archivos, se ha deshabilitado en todas las rutas que Belich utiliza para exportar archivos. A partir de esta situación (problemas con el `middleware` y las descargas), se decidió permitir la configuración de rutas que estuvieran excluidas de este `middleware`.

Se puede hacer de dos formas:

1. Indicando que acciones quremos excluir del `middleware`:

~~~
'minifyHtml' => [
    'enable'    => true,
    'except'  => [
        'actions' => ['index', 'show'],
        'paths'   => [],
    ],
],
~~~

2. Indicando las urls que queremos excluir:

~~~
'minifyHtml' => [
    'enable'    => true,
    'except'  => [
        'actions' => [],
        'paths'   => ['dashboard/users'],
    ],
],
~~~

>No es necesario preocuparse por si nuestra ruta empieza o termina con `/`. Belich las elimina de forma automática para hacer la comprobación.

## Eliminar gráficas (Metrics) según el tamaño de pantalla

Podemos indicarle a Belich, que no queremos mostrar gráficas en dispositivos pequeños, para ello, haremos lo siguiente:

~~~
'hideMetricsForScreens' => ['sm'],
~~~

Los valores soportados son:

- **sm**: a partir de 576px.
- **md**: a partir de 768px.
- **lg**: a partir de 992px.
- **xl**: a partir de 1200px.

>Esta misma opción, también esta disponible en cada recurso, por lo que se considerará el valor de este archivo como global, y el del recurso para particular. En caso de que ambos estén activos, prevalecerá el valor del recurso.


