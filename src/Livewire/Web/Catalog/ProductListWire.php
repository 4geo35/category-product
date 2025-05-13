<?php

namespace GIS\CategoryProduct\Livewire\Web\Catalog;

use GIS\CategoryProduct\Interfaces\CategoryInterface;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class ProductListWire extends Component
{
    use WithPagination;

    public CategoryInterface $category;
    public array $sortOptions = [];
    public string $query = "";
    public string $sortBy = "";
    public string $sortDirection = "";
    public array $filters = [];

    protected function queryString(): array
    {
        return [
            "sortBy" => ["as" => "sort-by", "except" => ""],
            "sortDirection" => ["as" => "sort-direction", "except" => ""],
            "filters" => ["as" => "filters", "except" => ""],
        ];
    }

    public function mount(): void
    {
        $this->sortOptions = config("category-product.sortOptions");
    }

    public function render(): View
    {
        return view("cp::livewire.web.catalog.product-list-wire");
    }
}
