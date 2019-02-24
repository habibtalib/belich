# belich (working on it...)
Laravel admin dashboard totaly inspired by the Nova documents, but totaly different...

The objective of the project is to follow the Laravel Nova line, but without the dependence on Vuejs. It is just a personal challence to build Nova without vuejs... just for fun! Only back-end!

And of course, all the code is built from 0!

## Status 

Project in development. Still in the early stages...help will be great!!!

## Instalation (not yet...)

`composer require daguilarm/belich`

## Configuration 

`php artisan vendor:publish --provider="Daguilarm\Belich\BelichServiceProvider" --force`

## Features 

- Sidebar or topbar from the `config` file.
- Resources download to: EXCEL and CSV.
- Native authorization with Policies.
- Icons with: https://origin.fontawesome.com
- Customized:
    + actions.
    + navbar.
    + sidebar.
    + breadcrumb.
    + dashboard.
    + ...
- Cache.
- Minify HTML (with filters by pages and Controller actions): https://github.com/nckg/laravel-minify-html
- Metrics using: https://gionkunz.github.io/chartist-js/index.html a lightweight library for charts.
- Simple tools for Metrics:

Showing the total users by day in the last week, is just this:

~~~
use App\User;
use Daguilarm\Belich\Components\Metrics\Eloquent\Connection;
use Daguilarm\Belich\Components\Metrics\Labels;
use Illuminate\Http\Request;

/**
 * Set the displayable labels
 *
 * @return string
 */
public function labels(Request $request) : array
{
    return Labels::daysOfTheMonth();
}

/**
 * Calculate from model
 *
 * @return string
 */
public function calculate(Request $request) : array
{
    return Connection::make(User::class)
        ->cacheInMinutes(10, $this->uriKey())
        ->thisWeek()
        ->totalByDay();
}
~~~

>In the documentation you will find a complete list of methods availables.

## Screenshots

#### With stats 

![Dashboard](https://raw.githubusercontent.com/daguilarm/belich/master/documents/images/stats1.png)

At the moment, Belich only has this type of metrics:

![Dashboard](https://raw.githubusercontent.com/daguilarm/belich/master/documents/images/metrics/graph-types.png)

The pie graph is working, but is not ready yet...

![Dashboard](https://raw.githubusercontent.com/daguilarm/belich/master/documents/images/metrics/graph-pie.png)

Due to Chartist don't have a great support for pie graph, I have to do all the work so...

#### And of course, with sidebar...

![Dashboard](https://raw.githubusercontent.com/daguilarm/belich/master/documents/images/sidebar.png)

## Videos

#### Dashboard
![Dashboard](https://raw.githubusercontent.com/daguilarm/belich/master/documents/videos/belich.gif)

![Dashboard](https://raw.githubusercontent.com/daguilarm/belich/master/documents/videos/code.gif)

