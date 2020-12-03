<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Icon extends Component
{
    public $name;
    public $class;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $class = "")
    {
        $this->name = $name;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.icon');
    }
}
