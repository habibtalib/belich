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

Las clases CSS que podemos sobreescribir:

- **nav-breadcrumbs**, clase de la etiqueta `nav`.
- **nav-breadcrumbs-list**, clase de las etiquetas `ul` o `ol`.
- **nav-breadcrumbs-items**, clase para las etiquetas `li` con enlace.
- **nav-breadcrumbs-items-current**, clase para las etiquetas `li` sin enlace, es decir, la página actual.
- **separator**, clase para el separador del breadcrumb. Por defecto utiliza `/`.

### Configuración de la clase `separator`:

El código CSS por defecto utilizado es:

~~~
.nav-breadcrumbs > ul > li.separator:after {
    @apply text-grey;
    content: '/\00a0';
}
~~~

Para personalizar el código CSS, consulte la sección sobre customización de CSS y Javascript, y sobreescriba los estilos basados en https://tailwindcss.com/.


