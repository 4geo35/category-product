<?php

namespace GIS\CategoryProduct\Helpers;

use GIS\CategoryProduct\Facades\CategoryActions;
use GIS\CategoryProduct\Facades\SpecificationActions;
use GIS\CategoryProduct\Interfaces\CategoryInterface;
use GIS\CategoryProduct\Interfaces\ProductInterface;
use GIS\CategoryProduct\Interfaces\SpecificationGroupInterface;
use GIS\CategoryProduct\Interfaces\SpecificationInterface;
use GIS\CategoryProduct\Interfaces\SpecificationValueInterface;
use GIS\CategoryProduct\Models\Product;
use GIS\CategoryProduct\Models\SpecificationGroup;
use GIS\CategoryProduct\Models\SpecificationValue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;

class ProductActionsManager
{
    public function setVisit(ProductInterface $product): array
    {
        $currentListJson = Cookie::get("productVisitList", "[]");
        $currentList = json_decode($currentListJson, true);
        if (! in_array($product->id, $currentList)) {
            $currentList[] = $product->id;
        }
        if (count($currentList) > config("category-product.storeVisitProductLimit")) {
            array_shift($currentList);
        }
        $cookie = Cookie::make("productVisitList", json_encode($currentList), 60*24*30);
        Cookie::queue($cookie);
        return $currentList;
    }

    public function getVisitCollection(ProductInterface $product): Collection
    {
        $currentListJson = Cookie::get("productVisitList", "[]");
        $currentList = json_decode($currentListJson, true);
        $productModel = config("category-product.customProductModel") ?? Product::class;
        return $productModel::query()
            ->select("id")
            ->whereIn("id", $currentList)
            ->whereNotNull("published_at")
            ->where("id", "!=", $product->id)
            ->inRandomOrder()
            ->limit(4)
            ->get();
    }

    public function getGridView(): string
    {
        return Cookie::get("productGridView", config("category-product.defaultGridView"));
    }

    public function setGridView(string $view): void
    {
        $cookie = Cookie::make("productGridView", $view, 60*24*30);
        Cookie::queue($cookie);
    }

    public function getTeaserData(int $id): ?ProductInterface
    {
        $key = "product-actions-getTeaserData:{$id}";
        return Cache::rememberForever($key, function () use ($id) {
            $productModelClass = config("category-product.customProductModel") ?? Product::class;
            return $productModelClass::query()
                ->where('id', $id)
                ->with("cover", "specifications")
                ->first();
        });
    }

    public function forgetTeaserData(int $id): void
    {
        Cache::forget("product-actions-getTeaserData:{$id}");
    }

    public function getSpecificationList(ProductInterface $product): array
    {
        $specificationsInfo = SpecificationActions::getSpecificationInfo();
        $specificationValues = $product->specifications;
        $sortedCollection = $this->prepareSpecificationCollection($specificationValues, $specificationsInfo);
        $limitCollection = $sortedCollection->take(config("category-product.teaserSpecificationLimit"));
        return $limitCollection->toArray();
    }

    public function getSpecifications(ProductInterface $product): Collection
    {
        return $product->specifications()
            ->join(
                "specifications",
                "specification_values.specification_id",
                "=",
                "specifications.id"
            )
            ->with(
                "specification:id,title,group_id,priority",
                "specification.group:id,title"
            )
            ->select(
                "specification_values.id",
                "specification_values.specification_id",
                "specification_values.value",

                "specifications.id as spec_id",
                "specifications.title",
                "specifications.priority",
                "specifications.group_id",
                "specifications.type"
            )
            ->orderBy("specifications.priority")
            ->orderBy("value")
            ->get();
    }

    public function getSpecificationsByGroup(ProductInterface $product): array
    {
        $specifications = $this->getSpecifications($product);
        $noGroup = [];
        $groups = [];
        foreach ($specifications as $item) {
            /**
             * @var SpecificationValueInterface $item
             */
            $specification = $item->specification;
            /**
             * @var SpecificationInterface $specification
             */
            $group = $specification->group;
            /**
             * @var SpecificationGroupInterface $group
             */
            $id = $specification->id;
            $value = $item->value;
            if ($item->type === "color") {
                $color = $item->color;
                $value .= "|" . $color->hash;
            }
            if (empty($group)) {
                if (empty($noGroup[$id])) {
                    $noGroup[$id] = (object) [
                        "values" => [],
                        "type" => $item->type,
                        "title" => $item->title,
                    ];
                }
                $noGroup[$id]->values[] = $value;
            } else {
                $groupId = $group->id;
                if (empty($groups[$groupId])) {
                    $groups[$groupId] = [
                        "title" => $group->title,
                        "items" => [],
                    ];
                }
                if (empty($groups[$groupId]["items"][$id])) {
                    $groups[$groupId]["items"][$id] = (object) [
                        "values" => [],
                        "type" => $item->type,
                        "title" => $item->title,
                    ];
                }
                $groups[$groupId]["items"][$id]->values[] = $value;
            }
        }

        $array = [];
        if (! empty($groups)) {
            $groupIds = array_keys($groups);
            $groupModelClass = config("category-product.customSpecificationGroupModel") ?? SpecificationGroup::class;
            $collectionOfIds = $groupModelClass::query()
                ->select("id")
                ->whereIn("id", $groupIds)
                ->orderBy("priority")
                ->get();
            foreach ($collectionOfIds as $item) {
                $array[] = (object) $groups[$item->id];
            }
        }

        return [
            "noGroup" => $noGroup,
            "groups" => $array,
        ];
    }

    public function getSpecificationValues(CategoryInterface $category): array
    {
        $key = "product-actions-getSpecificationValues:{$category->id}";
        return Cache::rememberForever($key, function () use ($category) {
            $cIds = CategoryActions::getChildrenIds($category, true);
            $valueModelClass = config("category-product.customSpecificationValueModel") ?? SpecificationValue::class;
            $values = $valueModelClass::query()
                ->leftJoin("products", "products.id", "=", "specification_values.product_id")
                ->leftJoin("specification_colors", "specification_colors.value_id", "=", "specification_values.id")
                ->select("specification_values.specification_id", "specification_values.value", "specification_colors.hash")
                ->whereNotNull("products.published_at")
                ->whereIn("specification_values.category_id", $cIds)
                ->orderBy("specification_values.product_id")
                ->get();

            return SpecificationActions::formatCollection($values);
        });
    }

    public function forgetSpecificationValues(CategoryInterface $category): void
    {
        Cache::forget("product-actions-getSpecificationValues:{$category->id}");
        if (! empty($category->parent_id)) {
            $this->forgetSpecificationValues($category->parent);
        }
    }

    protected function prepareSpecificationCollection(Collection $values, array $specificationsInfo): \Illuminate\Support\Collection
    {
        $result = [];
        foreach ($values as $specificationValue) {
            $specificationId = $specificationValue->specification_id;
            if (empty($specificationsInfo[$specificationId])) { continue; }
            $specificationInfo = $specificationsInfo[$specificationId];
            if (empty($result[$specificationId])) {
                $result[$specificationId] = (object) [
                    "title" => $specificationInfo->title,
                    "priority" => $specificationInfo->priority,
                    "values" => [],
                ];
            }
            $result[$specificationId]->values[] = $specificationValue->value;
        }
        $collection = collect($result);
        $sorted = $collection->sortBy(function (object $item) {
            return $item->priority;
        });
        return $sorted->map(function (object $item) {
            $result = $item;
            $sortedValues = Arr::sort($item->values);
            $result->values = $sortedValues;
            $result->stringValues = implode(", ", $sortedValues);
            return $result;
        });
    }
}
