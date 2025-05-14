<?php

namespace GIS\CategoryProduct\Livewire\Web\Catalog;

use GIS\CategoryProduct\Traits\CheckLikeFilterTrait;
use Livewire\Component;

class ColorFilterWire extends Component
{
    use CheckLikeFilterTrait;

    public string $template = "cp::livewire.web.catalog.color-filter-wire";
}
