![Logo](https://raw.githubusercontent.com/daguilarm/belich/master/documents/images/logo.png)

# belich (working on it...Released on January 1, 2020)

**Belich** is an administration panel based on [Laravel](https://laravel.com), and that has been influenced by the documentation of [Nova](https://nova.laravel.com), [Laravel Collective](https://laravelcollective.com/) and [Quickadmin](https://github.com/LaravelDaily/quickadmin).

The concept of **Belich**, is totally different, since the main idea is to base the development of the project on the *Back-end*, and therefore, eliminating any **javascript framework**, like [VueJS](https://vuejs.org/), [React](https://reactjs.org) or even [Jquery](https://jquery.com/)}, from the equation. 

The idea is to put all the weight in the `php` part, but allowing the necessary flexibility so that each user can integrate any technology or **framework** that they want.

**And this why?** Basically, to win in simplicity. With **Belich** is very easy to customize any field or section, and all this simplicity, without having to develop complex components with **javascript frameworks**.

And of course, all the code built from scratch, and integrating the latest available technologies.

## Status 

Project in development. Still in the early stages...help will be great!!!

## Requirements

- PHP 7.4 >
- Laravel 6.x

## Instalation (not yet...)

`composer require daguilarm/belich`

## Configuration 

`php artisan vendor:publish --provider="Daguilarm\Belich\BelichServiceProvider"`

## Test

All the tests are in https://github.com/daguilarm/belich-dashboard

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
    + cards
    + ...
- Cache.
- Tabs, panels, cards, metrics,...
- Minify HTML (with filters by pages and Controller actions): https://github.com/nckg/laravel-minify-html
- Metrics using: https://gionkunz.github.io/chartist-js/index.html a lightweight library for charts.
- Life search from index with custom fields.
- Conditional fields.

### Casting the fields before storage

~~~
use Daguilarm\Belich\Fields\Types\Text;

/**
 * Get the fields displayed by the resource.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return Illuminate\Support\Collection
 */
public function fields(Request $request) {
    return [
        Text::make('Status', 'status')
            ->toInteger(),
    ];
}
~~~

### Simple tools for Metrics:

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

## Docs 

https://github.com/daguilarm/belich-documents

## Screenshots

Most recent screenshot from the current design:

![Dashboard](https://raw.githubusercontent.com/daguilarm/belich/master/documents/images/2019-11-20.png)

## TODO

- Refactoring all the code, because I am just writting code...
- Complete the fields types:
    + Maps.
- Create the relationship fields:
    + <del>HasOne</del>
    + BelongsTo
    + HasMany
    + BelongsToMany
...
