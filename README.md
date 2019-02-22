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
- Metrics with: https://gionkunz.github.io/chartist-js/index.html
-Simples tools for Metrics:

Showing the total users by day in the last week, is just this:

~~~
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
public function calculate(Request $request)
{
    return $this
        ->thisWeek()
        ->getTotalByDay(User::class);
}
~~~

## Screenshots

#### With stats 

![Dashboard](https://raw.githubusercontent.com/daguilarm/belich/master/documents/images/stats.png)

#### Dashboard
![Dashboard](https://raw.githubusercontent.com/daguilarm/belich/master/documents/videos/belich.gif)

![Dashboard](https://raw.githubusercontent.com/daguilarm/belich/master/documents/videos/code.gif)


## And of course, with sidebar like Nova...

![Dashboard](https://raw.githubusercontent.com/daguilarm/belich/master/documents/images/sidebar.png)
