<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class SupplierLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    private $crumps;

    public function __construct($crumps = [])
    {
        $this->crumps = $crumps;
    }

    public function render(): View
    {
        return view('layouts.supplier', ['crumps' => $this->crumps]);
    }
}
