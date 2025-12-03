<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AdminLayout extends Component
{
    public $crumps;

    /**
     * Create a new component instance.
     */
    public function __construct($crumps = [])
    {
        $this->crumps = $crumps;
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.admin', ['crumps' => $this->crumps]);
    }
}
