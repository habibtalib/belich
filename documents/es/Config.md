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
