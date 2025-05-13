<?php

namespace GIS\CategoryProduct\Livewire\Web\Catalog;

use GIS\CategoryProduct\Interfaces\CategoryInterface;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Collection;

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
//            "query" => ["as" => "q", "except" => ""],
            "filters" => ["as" => "f", "except" => ""],
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

    #[On("change-filter-query")]
    public function applyFilters(string $newQuery, bool $isModal): void
    {
        // Передать в строку массив
        $result = [];
        parse_str($newQuery, $result);
        $this->filters = $result;

        $this->resetPage();
        $this->query = $newQuery;
//        request()->request->add(["q" => $newQuery]);
    }
}
