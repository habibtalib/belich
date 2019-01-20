<?php

namespace Daguilarm\Belich\Components;

use Belich;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\Menu\Html;
use Spatie\Menu\Link;
use Spatie\Menu\Menu;

abstract class Navigation {

    public static function brand()
    {
        return Link::to(Belich::url(), Belich::name())
            ->addParentClass('brand');
    }

    public static function resource(string $resource, Collection $resources)
    {
        $resource = Str::plural(Str::lower($resource));
        $label    = $resources[$resource]['pluralLabel'] ?? null;
        $url      = sprintf('%s/%s', Belich::url(), $resource);

        return $label
            ? Link::to($url, $label)
            : abort(403, trans('belich::exceptions.no_resource'));
    }

    public static function resourcesForNavigation(Collection $resources)
    {
        $menu =  Menu::new()->add(self::brand());

        $groups = collect($resources)
            ->map(function ($item, $key) {
                return $item['group'];
            })
            ->unique()
            ->values();

        $items = collect($resources)
            ->map(function ($items) {
                return $items->toArray();
            })
            ->values();

        foreach($groups as $group) {
            $submenu = Menu::new();
            foreach($items->where('group', $group) as $value) {
                if(!empty($value['pluralLabel'])) {
                    $submenu->link('/about', $value['pluralLabel']);
                }
            }
            $menu->submenu(Link::to('#', $group), $submenu);
        }

        return $menu;
    }
}
