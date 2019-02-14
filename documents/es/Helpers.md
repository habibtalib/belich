# Belich Helpers


Belich, dispone de una serie de helpers que pueden ser utilizados en cualquier parte del package de forma directa. A continuación, puedrá consultar la lista de métodos soportados:

#### toRoute()

Utilizado en los formularios de las vistas `edit` y `create`, para generar rápidamente las urls (a partir de rutas) del campo `action`.

El ejemplo utilizado por la vista create:

~~~
<form method="POST" action="{{ Belich::blade()->toRoute('store') }}">
~~~

En el caso de la vista `edit`, sería:

~~~
<form method="POST" action="{{ Belich::blade()->toRoute('update') }}">
~~~

Obteniendo automáticamente el identificador del recurso (ID), y generando la url a partir de él.
