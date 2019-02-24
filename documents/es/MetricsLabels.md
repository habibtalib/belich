# Etiquetas para gráficas

Belich incluye una herramienta para generar etiquetas en las gráficas, formateándolas a partir de archivos de idioma.

El archivo de idioma, se encuentra en `App\resources\langs\vendor\belich\en\metrics.php`

La forma de utilizar esta herramienta, es la siguiente:

~~~
use Daguilarm\Belich\Components\Metrics\Labels;

/**
 * Get the values from storage
 *
 * @return string
 */
public function labels(Request $request) : array
{
    return Labels::daysOfTheMonth();
}
~~~

>Recuerde que nos encontramos en un archivo de gráficas, que debe estar situado en `\App\Belich\Metrics`

Los métodos soportados son:

- **countriesOfTheWorld**: Devuelve un array con todos los nombres de los paises del mundo.
- **daysOfTheWeek**: Devuelve un array con los nombres de los días de la semana.
- **daysOfTheWeekMin**: Devuelve un array con los nombres de días de la semana (usando abreviaciones).
- **daysOfTheMonth**: Devuelve un array con los días del mes: de 1 a (28, 29, 30 o 31).
- **hoursOfTheday**: Devuelve un array con valores de 1 a 24.
- **monthsOfTheYear**: Devuelve un array con los nombres de los meses del año.
- **monthsOfTheYearMin**: Devuelve un array con los nombres de los meses del año (usando abreviaciones).
- **listOfYears**: Devuelve un array con los años en función del año inicial.

Agunos ejemplos:

~~~
use Daguilarm\Belich\Components\Metrics\Labels;

/**
 * Get the values from storage
 *
 * @return string
 */
public function labels(Request $request) : array
{
    return Labels::daysOfTheWeek();
}

//Will return
['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday']
~~~

O por el caso que puede crear más dudas:

~~~
use Daguilarm\Belich\Components\Metrics\Labels;

/**
 * Get the values from storage
 *
 * @return string
 */
public function labels(Request $request) : array
{
    return Labels::listOfYears(3);
}

//Will return if today is 2019
[2017, 2018, 2019]
~~~

Le hemos indicado que nos devuelva un array con los tres últimos años.

Los métodos que devuelven `strings`, como por ejemplo: `Labels::daysOfTheWeek()`, admiten un parámetro:

~~~
use Daguilarm\Belich\Components\Metrics\Labels;

/**
 * Get the values from storage
 *
 * @return string
 */
public function labels(Request $request) : array
{
    return Labels::daysOfTheWeek('capitalize');
}

//Will return if today is 2019
['MONDAY', 'TUESDAY', ...]
~~~

Es decir, podemos formatear la salida del array. Las opciones soportadas son:

- **capitalize**: nos devolverá el texto en mayúsculas.
- **lower**: nos devolverá el texto en minúculas.
- **title**:  nos devolverá el texto con la primera letra capitalizada (ucfirst). Esta es la opción por defecto.
