<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class GuestLayout extends Component
{
    /**
     * Ambil view yang merepresentasikan komponen ini.
     */
    public function render(): View
    {
        return view('layouts.guest');
    }
}
