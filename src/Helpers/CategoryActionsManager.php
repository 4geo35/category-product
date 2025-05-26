<?php

namespace GIS\CategoryProduct\Helpers;

use GIS\CategoryProduct\Interfaces\CategoryInterface;
use GIS\CategoryProduct\Models\Category;
use GIS\CategoryProduct\Models\Product;
use GIS\TraitsHelpers\Interfaces\ShouldTreeInterface;
use GIS\TraitsHelpers\Traits\ManagerTreeTrait;
use Illuminate\Support\Facades\Cache;

class CategoryActionsManager
{
    use ManagerTreeTrait;

    public function __construct()
    {
        $this->modelClass = config("category-product.customCategoryModel") ?? Category::class;
        $this->hasImage = true;
    }

    public function getProductIds(CategoryInterface $category, bool $includeSubs = false): array
    {
        $key = "category-actions-getProductIds:{$category->id}";
        $key .= $includeSubs ? "-true" : "-false";
        return Cache::rememberForever($key, function () use ($category, $includeSubs) {
            $productModelClass = config("category-product.customProductModel") ?? Product::class;
            $query = $productModelClass::query()
                ->select("id")
                ->whereNotNull("published_at");
            if ($includeSubs) {
                $query->whereIn("category_id", $this->getChildrenIds($category, true));
            } else {
                $query->where("category_id", $category->id);
            }
            $products = $query->get();
            $pIds = [];
            foreach ($products as $product) {
                $pIds[] = $product->id;
            }
            return $pIds;
        });
    }

    public function forgetProductIds(CategoryInterface $category): void
    {
        $key = "category-actions-getProductIds:{$category->id}";
        Cache::forget("$key-true");
        Cache::forget("$key-false");
        if (! empty($category->parent_id)) { $this->forgetProductIds($category->parent); }
    }

    public function getParents(CategoryInterface $category): array
    {
        $key = "category-actions-getParents:{$category->id}";
        return Cache::rememberForever($key, function () use ($category) {
            $result = [];
            if ($category->parent) {
                $result[] = (object)[
                    "id" => $category->parent->id,
                    "slug" => $category->parent->slug,
                    "title" => $category->parent->title,
                ];
                $result = array_merge($this->getParents($category->parent), $result);
            }
            return $result;
        });
    }

    public function forgetParents(CategoryInterface $category): void
    {
        Cache::forget("category-actions-getParents:{$category->id}");
        foreach ($category->children as $child) {
            $this->forgetParents($child);
        }
    }

    public function getChildrenIds(CategoryInterface $category, bool $includeSelf = false): array
    {
        $key = "category-actions-getChildrenIds:{$category->id}";
        $key .= $includeSelf ? "-true" : "-false";
        return Cache::rememberForever($key, function () use ($category, $includeSelf) {
            $ids = [];
            if ($includeSelf) { $ids[] = $category->id; }
            $children = $category->children()->select("id")->whereNotNull("published_at")->get();
            foreach ($children as $child) {
                /**
                 * @var CategoryInterface $child
                 */
                $ids[] = $child->id;
                $ids = array_merge($ids, $this->getChildrenIds($child));
            }
            return array_unique($ids);
        });
    }

    public function forgetChildrenIds(CategoryInterface $category): void
    {
        $key = "category-actions-getChildrenIds:{$category->id}";
        Cache::forget("{$key}-true");
        Cache::forget("{$key}-false");
        if ($category->parent_id) $this->forgetChildrenIds($category->parent);
    }

    public function cascadeShutdown(CategoryInterface $category): void
    {
        foreach ($category->children as $child) {
            if (! $child->published_at) { continue; }
            $child->update([
                "published_at" => null,
            ]);
        }
        // TODO: does need make a queue?
        $products = $category->products()
            ->whereNotNull("published_at")
            ->get();
        foreach ($products as $product) {
            $product->update([
                "published_at" => null,
            ]);
        }
    }

    protected function expandItemData(&$data, ShouldTreeInterface $category): void
    {
        $data["published_at"] = $category->published_at ?? null;
    }
}
