<?php

namespace Daguilarm\Belich\Core;

class Component {
    //Set the three base containers
    private $header;
    private $content;
    private $footer;

    public function make($component, $folder = null)
    {
        //Define component path
        $component = $folder ? $folder . '.' . $component : $component;

        return view('belich::components.' .  $component);
    }
}
