<?php

namespace GIS\CategoryProduct\Livewire\Admin\Categories;

use GIS\CategoryProduct\Interfaces\CategoryInterface;
use GIS\CategoryProduct\Traits\CategoryEditActions;
use GIS\TraitsHelpers\Traits\WireDeleteImageTrait;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class ShowWire extends Component
{
    use WithFileUploads, WireDeleteImageTrait;
    use CategoryEditActions;

    public CategoryInterface $category;

    public function render(): View
    {
        return view('cp::livewire.admin.categories.show-wire');
    }
}
