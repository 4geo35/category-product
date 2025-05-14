<?php

namespace GIS\CategoryProduct\Traits;

use Illuminate\View\View;
use Livewire\Attributes\Modelable;

trait CheckLikeFilterTrait
{
    public object $data;
    #[Modelable]
    public array $values = [];
    public string $search = "";
    public bool $isModal = false;
    public bool $isCollapse = true;

    public function render(): View
    {
        $total = count($this->data->values);
        $filteredValues = $this->filterValues();
        $forShow = config("category-product.checkboxShowCount");
        $hasMore = count($filteredValues) > $forShow;
        $needSearch = $total > $forShow;
        if ($this->isCollapse) {
            $showMore = count($filteredValues) - $forShow;
            if ($showMore <= 0) $showMore = false;
        } else $showMore = false;
        if ($showMore) {
            $filteredValues = array_slice($filteredValues, 0, $forShow);
        }
        return view(
            $this->template,
            compact("filteredValues", "showMore", "hasMore", "needSearch")
        );
    }

    public function switchCollapse(): void
    {
        $this->isCollapse = ! $this->isCollapse;
    }

    protected function filterValues(): array
    {
        $values = $this->data->renderValues;
        if (empty($this->search)) return $values;
        $collection = collect($values);
        $search = $this->search;
        $filtered = $collection->filter(function (array $item, int $key) use ($search) {
            return mb_stripos(trim($item["value"]), trim($search)) !== false;
        });
        return $filtered->toArray();
    }
}
