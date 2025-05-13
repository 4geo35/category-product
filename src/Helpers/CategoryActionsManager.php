<?php

namespace GIS\CategoryProduct\Helpers;

use GIS\CategoryProduct\Interfaces\CategoryInterface;
use GIS\CategoryProduct\Models\Category;
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
