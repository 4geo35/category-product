<?php

namespace GIS\CategoryProduct\Livewire\Web\Catalog;

use GIS\CategoryProduct\Facades\ProductFiltersActions;
use GIS\CategoryProduct\Interfaces\CategoryInterface;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class CategoryFilterWire extends Component
{
    public CategoryInterface $category;
    public array $filters = [];

    public array $filterItems = [];
    public bool $isModal = false;

    public function mount(): void
    {
        $this->filters = ProductFiltersActions::getFilters($this->category, true);
        $this->setFilterItems();
    }

    public function render(): View
    {
        // Для range слайдера, иначе он увидит изменения только в одном из фильтров
        $this->dispatch("filter-ready-for-render");
        return view("cp::livewire.web.catalog.category-filter-wire");
    }

    public function applyFilters(): void
    {
        $query = Arr::query($this->filterItems);
        $this->dispatch("change-filter-query", newQuery: $query, isModal: $this->isModal);
    }

    public function resetFilters(): void
    {
        $query = "";
        $this->setFilterItems();
        $this->dispatch("change-filter-query", newQuery: $query, isModal: $this->isModal);
    }

    #[On("change-filter-query")]
    public function updateFilters(string $newQuery, bool $isModal): void
    {
        if ($isModal == $this->isModal) return;
        $this->setFilterItems($newQuery);
    }

    protected function setFilterItems(string $newQuery = ""): void
    {
        if ($newQuery) {
            $result = [];
            parse_str($newQuery, $result);
        } else {
            // Пробуем брать из запроса напрямую
            $queryArray = request()->query();
            if (! empty($queryArray["f"])) { $result = $queryArray["f"]; }
            else { $result = []; }
        }

        foreach ($this->filters as $item) {
            if (! empty($result[$item->slug])) {
                $value = $result[$item->slug];
            } else {
                $value = match ($item->type) {
                    "checkbox", "color" => [],
                    "range" => [
                        "from" => (int) $item->min,
                        "to" => (int) $item->max,
                    ],
                    default => null,
                };
            }
            $this->filterItems[$item->slug] = $value;
        }
    }
}
