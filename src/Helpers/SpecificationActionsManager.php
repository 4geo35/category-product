<?php

namespace GIS\CategoryProduct\Helpers;

use GIS\CategoryProduct\Models\Specification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

class SpecificationActionsManager
{
    public function getCollection(): Collection
    {
        $key = "specification-actions-getCollection";
        return Cache::rememberForever($key, function () {
            $specificationModelClass = config("category-product.customSpecificationModel") ?? Specification::class;
            return $specificationModelClass::query()
                ->with("group:id,title")
                ->select("id", "title", "group_id", "type", "in_filter", "priority", "slug")
                ->orderBy("title")
                ->get();
        });
    }

    public function clearCollection(): void
    {
        Cache::forget("specification-actions-getCollection");
    }

    public function getSpecificationInfo(bool $filter = false): array
    {
        $collection = $this->getCollection();
        $specs = [];
        foreach ($collection as $item) {
            $specs[$item->id] = (object)[
                "id" => $item->id,
                "title" => $item->title,
                "slug" => $item->slug,
                "filter" => $item->in_filter,
                "type" => $item->type,
                "group_id" => $item->group_id,
                "priority" => $item->priority,
            ];
        }
        if ($filter) { return $this->sortForFilter($specs); }
        return $specs;
    }

    public function formatCollection(Collection $collection): array
    {
        $values = [];
        foreach ($collection as $item) {
            $specId = $item->specification_id;
            if (empty($values[$specId])) {
                $values[$specId] = [];
            }
            if (! empty($item->value)) {
                $value = $item->value;
                if (! empty($item->hash)) { $value .= "|" . $item->hash; } // Это для цвета
                $values[$specId] = array_unique(
                    array_merge($values[$specId], Arr::wrap($value))
                );
            }
        }
        return $values;
    }

    protected function sortForFilter(array $data): array
    {
        $filtered = [];
        foreach ($data as $id => $item) {
            if (! $item->filter) continue;
            $filtered[$id] = $item;
        }
        return $filtered;
    }
}
