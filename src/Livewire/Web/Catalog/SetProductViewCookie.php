<?php

namespace GIS\CategoryProduct\Livewire\Web\Catalog;

use GIS\CategoryProduct\Facades\ProductActions;
use Livewire\Attributes\On;
use Livewire\Component;

class SetProductViewCookie extends Component
{
    public function render(): string
    {
        return "<div></div>";
    }

    #[On("change-product-grid-view")]
    public function setViewCookie(string $view): void
    {
        ProductActions::setGridView($view);
    }
}
