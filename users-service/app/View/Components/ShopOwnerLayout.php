<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class ShopOwnerLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */

    public $crumps;

    public function __construct($crumps = [])
    {
        $this->crumps = $crumps;
    }
    
    public function render(): View
    {
        return view('layouts.phsar', ['crumps' => $this->crumps]);
    }
}
