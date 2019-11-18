# belich (working on it...Released on January 1, 2020)

I started this project to improve my skills as a programmer, and for that, I immersed myself in the Laravel Nova code (it was something that changed my way of understanding programming).

From that point, I decided as an exercise, to develop a version of Nova that did not use VueJS, in other words, focused on the back-end, and using Javascript only in cases where there was no other option available. **The package uses only vanilla javascript, completely eliminating the use of any javascript frameworks, although these can be used without any problem, according to the user's needs**.

What has happened during this adventure, is that in the end, what started as an exercise, is becoming a real project, and gradually moving away from Nova, especially when I have added new features, which have made me (on several occasions) rebuild a good part of the code from the beginning.

Choosing to eliminate VueJS from the equation has been a very complicated decision, and in some cases, it has been a big headache.

To this day, Belich has its own code structure designed from 0 and will be 100% costomized by the user.

The adventure is worth it, and I think I've learned great things!

## Status 

Project in development. Still in the early stages...help will be great!!!

## Requirements

- PHP 7.3
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
- Minify HTML (with filters by pages and Controller actions): https://github.com/nckg/laravel-minify-html
- Metrics using: https://gionkunz.github.io/chartist-js/index.html a lightweight library for charts.
- Life search from index with custom fields.

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

#### With stats 

![Dashboard](https://raw.githubusercontent.com/daguilarm/belich/master/documents/images/stats1.png)

At the moment, Belich only has this type of charts:

![Dashboard](https://raw.githubusercontent.com/daguilarm/belich/master/documents/images/metrics/graph-types.png)

![Dashboard](https://raw.githubusercontent.com/daguilarm/belich/master/documents/images/metrics/graph-pie.png)

#### Tabs

![Tabs](https://raw.githubusercontent.com/daguilarm/belich/master/documents/images/tabs.png)

#### With stats and cards

![Dashboard](https://raw.githubusercontent.com/daguilarm/belich/master/documents/images/card-and-pie.png)

#### And of course, with sidebar...

![Dashboard](https://raw.githubusercontent.com/daguilarm/belich/master/documents/images/sidebar.png)

## Videos

#### Dashboard
![Dashboard](https://raw.githubusercontent.com/daguilarm/belich/master/documents/videos/belich.gif)

![Dashboard](https://raw.githubusercontent.com/daguilarm/belich/master/documents/videos/code.gif)

## TODO

- Refactoring all the code, because I am just writting code...
- Complete the fields types:
    + DependsOn fields
    + Maps.
- Create the relationship fields.
- Writting test... I know but...
- Preset cards.
...
