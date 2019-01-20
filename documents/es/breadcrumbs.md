# Breadcrumbs

Los breadcrumbs pueden ser configurados desde la vista situada en `resources/views/vendor/belich/partials/breadcrumbs.blade.php`. El template básico tiene el siguiente formato:

~~~
<nav class="nav-breadcrumbs">
    <ul class="nav-breadcrumbs-list">
        @foreach($resource['breadcrumbs'] as $key => $value)
            @if(empty($value['url']))
                <li class="nav-breadcrumbs-items-current">{{ $value['title'] }}</li>
            @else
                <li class="nav-breadcrumbs-items">
                    <a href="{{ $value['url'] }}" class="text-blue font-bold">
                        {{ $value['title'] }}
                    </a>
                </li>
            @endif
            @if(!$loop->last)
                <li class="separator">/</li>
            @endif
        @endforeach
    </ul>
</nav>
~~~

La variable `$resource` contiene toda la información del recurso actual, y de ella, podemos obtener el array con los breadcrumbs.

Por defecto, Belich utiliza la Facade `Belich`, llamando al método `Belich::breadcrumbs()`. Renderizando de forma automática el código HTML del ejemplo.

El código de ejemplo anterior, se encuentra en el template comentado, en caso de que queramos personalizarlo.

La forma nativa para inicializar el template será:

~~~
{!! Belich::breadcrumbs() !!}
~~~

## Customización

A continuación, se puede ver el código completo CSS de los breadcrumbs:

~~~
.nav-breadcrumbs {
    @apply w-full mb-8 bg-white;
}

    .nav-breadcrumbs > ul {
        @apply list-reset flex shadow-md my-4 p-4;
    }

    .nav-breadcrumbs > ul > li {
        @apply mr-2 font-semibold text-grey-darker;
    }

    .nav-breadcrumbs > ul > li > a {
        @apply font-medium text-grey-dark underline;
    }

    .nav-breadcrumbs > ul > li > a:hover {
        @apply text-blue;
    }

    .nav-breadcrumbs > ul > li.separator:after {
        @apply text-grey;
        content: '/\00a0';
    }
~~~


### Personalización de la clase `separator`:

El código CSS por defecto utilizado es:

~~~
.nav-breadcrumbs > ul > li.separator:after {
    @apply text-grey;
    content: '/\00a0';
}
~~~


Modifíquelo según sus necesidades.


### Sobreescribir los estilos del breadcrumb:

Para personalizar el código CSS, deberá sobreescribir los estilos CSS. Para ello, tiene dos opciones:

1. Modificar el archivo `./public/vendor/belich/app.class`
2. Crear un archivo nuevo, por ejemplo: customCss, usando la extensión que prefiramos: `.css`, `.less`, `.scss`,...y guardarla en `./resources/vendor/belich/customCss.scss`. Ahora solo tenemos que ir, al archivo `webpack.mix.js`, y añadir el siguiente código:

~~~
mix.sass('resources/vendor/belich/customCss.scss', '/public/vendor/belich/app.class');
~~~

