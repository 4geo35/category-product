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
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;

class ProductActionsManager
{
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
                ->with("cover")
                ->first();
        });
    }

    public function forgetTeaserData(int $id): void
    {
        Cache::forget("product-actions-getTeaserData:{$id}");
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
}
