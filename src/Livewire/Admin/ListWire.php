<?php

namespace GIS\CategoryProduct\Livewire\Admin;

use Illuminate\View\View;
use Livewire\Component;

class ListWire extends Component
{
    public function render(): View
    {
        return view('cp::livewire.admin.categories.list-wire');
    }
}
