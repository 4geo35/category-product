<?php

namespace GIS\CategoryProduct\Traits;

use GIS\CategoryProduct\Facades\CategoryActions;
use GIS\CategoryProduct\Facades\SpecificationActions;
use GIS\CategoryProduct\Models\Product;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

trait FilterQuery
{
    protected function initQuery(): void
    {
        $productModelClass = config("category-product.customProductModel") ?? Product::class;
        $this->query = $productModelClass::query();
        // TODO: check variation
        $this->query->select("products.id");

        $this->query->whereNotNull("products.published_at");
    }

    protected function initCategoryQuery(): void
    {
        $this->categoryIds = CategoryActions::getChildrenIds($this->category, true);
        $this->query->whereIn("products.category_id", $this->categoryIds);
        $this->fillSlugValues();
    }

    protected function fillSlugValues(): void
    {
        $specInfo = SpecificationActions::getSpecificationInfo(true);
        foreach ($specInfo as $item) {
            $this->slugValues[$item->slug] = [
                "id" => $item->id,
                "type" => $item->type,
            ];
        }
        // TODO: add variations
    }

    protected function applyFilters(int $perPage = null): LengthAwarePaginator
    {
        $params = $this->request->get("f", []);
        foreach ($params as $key => $value) {
            if (empty($value)) { continue; }
            if (!isset($this->slugValues[$key])) { continue; }
            if ($this->addCheckboxToQuery($key, $value)) { continue; }
            if ($this->addColorToQuery($key, $value)) { continue; }
            if ($this->addRangeToQuery($key, $value, $params)) continue;
        }

        // TODO: add variations

        $this->query->groupBy("products.id");
        $this->addSortCondition();

        if (!$perPage) $perPage = config("category-product.categoryProductsPerPage");
        return $this->query->paginate($perPage)->appends($this->request->input());
    }

    protected function addSortCondition(): void
    {
        $sort = $this->request->get("sort-by", config("category-product.defaultSort"));
        $direction = $this->getCurrentSortDirection();
        if (Schema::hasColumn("products", $sort)) {
            $this->query->orderBy("products.{$sort}", $direction);
        } elseif (config("product-variation") && $sort == "price") {
            $this->query->orderBy("priceSort", $direction);
        }
    }

    protected function getCurrentSortDirection(): string
    {
        $defaultSortDirection = config("category-product.defaultSortDirection");
        $direction = $this->request->get("sort-order", $defaultSortDirection);
        if (!in_array($direction, ["asc", "desc"])) $direction = $defaultSortDirection;
        return $direction;
    }

    protected function addCheckboxToQuery($key, $value): bool
    {
        if ($this->slugValues[$key]["type"] !== "checkbox") { return false; }

        $checkboxes = DB::table("specification_values")
            ->select("product_id")
            ->whereIn("category_id", $this->categoryIds)
            ->where("specification_id", $this->slugValues[$key]["id"])
            ->whereIn("value", $value)
            ->groupBy("product_id");

        $this->query->joinSub($checkboxes, $key, function (JoinClause $join) use ($key) {
            $join->on("products.id", "=", "{$key}.product_id");
        });

        return true;
    }

    protected function addColorToQuery($key, $value): bool
    {
        if ($this->slugValues[$key]["type"] !== "color") { return false; }

        $colorValues = DB::table("specification_values")
            ->select("product_id", "specification_id", "value")
            ->whereIn("category_id", $this->categoryIds)
            ->where("specification_id", $this->slugValues[$key]["id"])
            ->get();

        $fullColorValues = [];
        foreach ($value as $colorTitle) {
            $filtered = $colorValues->filter(function ($item) use ($colorTitle) {
                return strstr($item->value, $colorTitle);
            });
            $result = $filtered->map(function ($item) {
                return $item->value;
            });
            $fullColorValues = array_merge($fullColorValues, array_values($result->toArray()));
        }

        $colors = DB::table("specification_values")
            ->select("product_id")
            ->whereIn("category_id", $this->categoryIds)
            ->where("specification_id", $this->slugValues[$key]["id"])
            ->whereIn("value", $fullColorValues)
            ->groupBy("product_id");

        $this->query->joinSub($colors, $key, function (JoinClause $join) use ($key) {
            $join->on("products.id", "=", "{$key}.product_id");
        });

        return true;
    }

    protected function addRangeToQuery($key, $value, &$params): bool
    {
        // TODO add variations

        $ranges = DB::table("specification_values")
            ->select("product_id")
            ->whereIn("category_id", $this->categoryIds)
            ->where("specification_id", $this->slugValues[$key]["id"])
            ->whereBetween("value", [$value["from"], $value["to"]])
            ->groupBy("product_id");

        $this->query->joinSub($ranges, $key, function (JoinClause $join) use ($key) {
            $join->on("products.id", "=", "{$key}.product_id");
        });

        return true;
    }
}
