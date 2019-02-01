# Utils Facade


Belich, dispone de una Facade llamada `Utils` que puede ser utilizada de forma directa (sin necesidad de configurar nada), desde cualquier parte del proyecto.

Podemos utilizarla en nuestro template:

~~~
{{ Utils::url() }}
~~~

Los métodos soportados son:

#### url() 

Nos devuelve la url actual con todos los parámetros, por ejemplo: 

`http://www.url.com/?perPage=20&page=2&relationship=billings`

#### urlWithOrder()

Igual que la anterior, pero añade dos nuevos parámetros:

- **order**: que será el campo de la base de datos por el que queremos ordenar la lista.
- **direction**: aceptando los parámetros `ASC` y `DESC`.

Quedando algo así:

`http://www.url.com/?perPage=20&page=2&relationship=billings&order=users&direction=DESC`

#### count($value)

Nos devuelve el númeor total de items que tiene una variable. El sistema distingue entre arrays, objectos y strings... por lo que devolverá el valor correcto en función del formato.

#### value($data, $attribute)

Es similar al helper de Laravel `data_get(), pero con la salvedad de que los atributos soportados por Belich, incluyen arrays con la relationship. tipo:

~~~
[
    'billings',
    'billing_name'
]
~~~

Es decir, estaríamos en un caso del tipo:

~~~
$data->billings->billing_name
~~~

Algo que `data_get()` no soporta.

#### urlParameters()

Devuelve un array con todas los parámetros de la url. Usando el ejemplo anterior:

~~~
[
    'perPage': 20,
    'page': 2
]
~~~


#### basePath()

Devuelve el nombre del directorio raiz sobre el que esta instalado Belich. Por defecto: `dashboard`.

#### formRedirectTo(string $redirectTo)

Genera la ruta para ser utilizada como attributo `action` en un formulario. Automáticamente determina todos los parámetros necesarios en función de la situación... Sólo tenemos que indicar hacia que acción se envia el formulario: index, update, create,...

Si nos encontramos editando un formulario, nos podríamos encontrar el siguiente código:

~~~
<form method="POST" action="{{ Utils::formRedirectTo('update') }}">
~~~

Automáticamente, generaría el siguiente código html:

~~~
<form method="POST" action="https://url.com/dashboard/users/2">
~~~

El sistema automáticamente determina el `id`, y lo añade por defecto.
